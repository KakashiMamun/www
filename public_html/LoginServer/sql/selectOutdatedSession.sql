SELECT user_id,exp_date FROM Bang.session_table WHERE exp_date <= NOW();
DELETE FROM Bang.session_table WHERE exp_date <= NOW();