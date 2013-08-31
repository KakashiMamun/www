<?php

Class ICodeCart {                                          
    public static $insertFields=array('customerId','amount','currencyCode','productId');
    public static $updateFields=array('cartId','customerId','amount','currencyCode','productId');
    public static $tableName='icode_cart';
    public static $idName='cart_id';
    public static $formIdName='cartId';
    public static $className='ICodeCart';
                              
    public static function Add()
    {
        if(($status=ICodeCart::Validate())!==1)
            return $status;

        $insertSql = "insert into icode_cart(
                     customer_id,product_id,currency_code,status,cart_date,amount,
                     name,address,city_id,
                     state_id,postcode,country_code, product_type
                     )
                     values(
                     '{$_POST['customerId']}','{$_POST['productId']}','{$_POST['currencyCode']}','payment_waiting',now(),'{$_POST['amount']}',
                     '{$_POST['name']}','{$_POST['address']}','{$_POST['cityId']}',
                     '{$_POST['stateId']}','{$_POST['postcode']}','{$_POST['countryCode']}','{$_POST['productType']}'

                     )";
        if(($cartId=ICodeDB::FreshInsertAndGetId($insertSql,ICodeCart::$tableName))>0)
        {
            return $cartId;
        }
        return 'Cart creation failed.';
    }      
    public static function Update()
    {      
        if(($status=ICodeCart::Validate())!==1)
            return $status;
        //process password
        $updateSql='update icode_cart set where cart_id='.$_POST['cartId'];
        $and='';

        return ICodeDB::Update($updateSql);
    }
    public static function Validate()
    {
        //check non empty, not isset, etc
        $update=false;
        if(isset($_POST[ICodeCart::$formIdName]) && (int)$_POST[ICodeCart::$formIdName]>0) //means update
            $update=true;
        if($update)
        {
            $mustFields=ICodeCart::$updateFields;
        }
        else
            $mustFields=ICodeCart::$insertFields;

        if(($status=ICodeFormValidation::ValidateNonEmpty($mustFields))!==1)
            return $status;

        //now custom validation
        if($update)
        {
            $uniqueCond='and cart_id!='.$_POST['cartId'];
            if((int)$_POST['cartId']==0)
                return 'Invalid cart id';
        }
        else
        {
            if((int)$_POST['amount']<=0)
                return "Cart amount cannot be empty";
        }
        return 1;
    }

    public static function ChangeStatus($cartId, $status) {
        $query = "update icode_cart set status ='$status' where cart_id=$cartId";
        if (ICodeDB::Update($query))
            return 'Status Updated';
        else
            'Status Update Failed';
    }

    public static function ChangeStatusByUser($cartId, $customerId, $status) {
        $query = "update icode_cart set status ='$status' where cart_id=$cartId and customer_id=$customerId";
        if (ICodeDB::Update($query))
            return 'Status Updated';
        else
            'Status Update Failed';
    }

    public static function GetByUser($customerId, $start=0, $limit=0, $afterId=0) {
        $upto = '';
        if ($limit > 0)
            $upto = " limit $start,$limit";
        return ICodeDB::GetResultsSet("select * from icode_cart where customer_id = $customerId order by cart_id asc $upto");
    }

    public static function Get($start=0, $limit=0, $afterId=0) {
        $upto = '';
        if ($limit > 0)
            $upto = " limit $start,$limit";
        return ICodeDB::GetResultsSet("select * from icode_cart order by cart_id asc $upto");
    }

    public static function GetInfo($cartId) {
        $query = "select * from icode_cart where cart_id=$cartId";
        return ICodeDB::GetResultRow($query);
    }         

    public static function GetInfoByTxnId($txnId) {
        $query = "select * from icode_cart where transaction_id='$txnId'";
        return ICodeDB::GetResultRow($query);
    }

    public static function GetTotal() {
        $query = "select count(cart_id) as count from icode_cart";
        $row = ICodeDB::GetResultRow($query);
        return $row['count'];
    }

    public static function CountByUser($customerId) {
        $query = "select count(cart_id) as count from icode_cart where customer_id = $customerId";
        $row = ICodeDB::GetResultRow($query);
        return $row['count'];
    }

    public static function Remove($cartId) {
        if (ICodeDB::DeleteRecord("delete from icode_cart where cart_id=$cartId limit 1"))
            return "Removed";
        return "DB error";
    }

    public static function RemoveByUser($cartId, $customerId) {
        if (ICodeDB::DeleteRecord("delete from icode_cart where cart_id=$cartId and customer_id = $customerId limit 1"))
            return "Removed";
        return "DB error";
    }

    public static function AcceptPayment($paymentInfo, $paymentType)
    {                       
        global $CONFIGURATIONS;
        $payingAccount = '';
        $transactionId = '';
        $cartId = '';
        if ($paymentType == 'paypal') {
            //payer_email , txn_id,invoice
            $payingAccount = $paymentInfo['payer_email'];
            $transactionId = $paymentInfo['txn_id'];
            $cartId = $paymentInfo['cartId'];
        }
        $query = "update icode_cart set paying_account = '$payingAccount',
                                  transaction_id = '$transactionId',
                                  payment_date = now(),
                                  status = 'payment_recieved'
                                  where cart_id = $cartId";
        if((int)$CONFIGURATIONS['LOG_TRANSACTIONS']==1)
            ICodeError::Log($query);
        if (ICodeDB::Update($query))
        {
            //process after payment                            
            //return SomeClass::ProcessAfterPayment($cartId);
            $cartInfo=ICodeCart::GetInfo($cartId);
            return call_user_func(array(ucfirst($cartInfo['product_type']),'ProcessAfterPayment'),$cartId);
            //return Site::ProcessAfterPayment($cartId);
        }
        return false;
    }

    public static function IsOwner($customerId, $cartId) {
        $query = "select count(*) from icode_cart where customer_id = '$customerId' and cart_id = '$cartId'";
        $result = ICodeDB::GetResultRow($query);
        if (!empty($result))
            return true;
        return false;
    }
    public static function GetExpiryDate($cartId)
    {
        $query="select DATE_FORMAT(DATE_ADD(payment_date, INTERVAL 30 DAY),'%M %d, %Y') as expiry_date from icode_cart where cart_id=$cartId";
        $row=ICodeDB::GetResultRow($query);
        return($row['expiry_date']);
    }
    public static function IsExpired($cartId)
    {   
        $query="select UNIX_TIMESTAMP() - UNIX_TIMESTAMP(payment_date) as time_passed from icode_cart where cart_id=$cartId";
        $row=ICodeDB::GetResultRow($query);
        $row['time_passed']=floor($row['time_passed']/86400);
        if(intval($row['time_passed'])>30)
            return true;
        return false;
    }

}

?>