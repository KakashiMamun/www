
                   <div class='subHead'>
                        <span class='subHeadLeft'>
                              <div>Manage Administrators</div>
                        </span><span class='subHeadRight'>
                        </span>
                   </div>                                                  
                   <table class='backTable' cellspacing=0 cellpadding=0>
                          <tr>           
                              <th>First Name
                              </th>
                              <th>Surname
                              </th>  
                              <th>Email
                              </th>
                              <th>Mobile
                              </th>    
                              <th>Sites
                              </th>
                              <th>Workgroups
                              </th>
                              <th>Invitation Date
                              </th>
                              <th>Joining Date
                              </th>
                              <th>Action
                              </th>
                          <tr> 
                          <?php
                              $count=0;
                              foreach($administrators as $aAdministrator)
                              {             
                                  $userInfo=User::GetCompleteInfo($aAdministrator['administrator_id']);  
                                  $ownerId=Administrator::GetOwnerId($aAdministrator['administrator_id']);
                                  if($count%2 ==0)
                                      $rowClass='evenRow';
                                  else         
                                      $rowClass='oddRow';
                                  ++$count;                
                                        
                                  $workgroupHtml='';
                                  $br='';
                                  $firstSite['name']='None';
                                  $invitationInfo['date_sent']='';
                                  $invitationInfo['date_joined']='';
                                  $sites=Site::GetByAdministrator($aAdministrator['administrator_id']);
                                  if(empty($sites))
                                  {
                                      $invitationInfo=Invitation::GetLastInvitationInfo($aAdministrator['administrator_id'],$ownerId);
                                  }
                                  else
                                  {
                                      $firstSite=array_pop($sites);
                                      $invitationInfo=Invitation::GetSiteInvitationInfo($firstSite['site_id'],$aAdministrator['administrator_id']);
                                      $workgroups=Workgroup::GetByAdministrator($aAdministrator['administrator_id'],$currentUserId,$status='active',$firstSite['site_id']);

                                      foreach($workgroups as $aWG)
                                      {
                                          $workgroupHtml.=$br.$aWG['name'];
                                          $br='<br>';
                                      }
                                  }
                                  $action='';
                                  if($invitationInfo['date_joined']!='pending')
                                  {
                                      if(Administrator::IsSuspended($aAdministrator['administrator_id'],$currentUserId))
                                          $action="<a href='javascript:void(0)' onclick='ReinstateForm(\"{$aAdministrator['administrator_id']}\")'>REINSTATE</a>";
                                      else
                                          $action="<a href='javascript:void(0)' onclick='Suspend(\"{$aAdministrator['administrator_id']}\")'>SUSPEND</a>";
                                  }
                                  echo"
                                      <tr class='$rowClass'>      
                                          <td>                     
                                              {$userInfo['f_name']}                 
                                          </td>
                                          <td>
                                              {$userInfo['l_name']}
                                          </td>   
                                          <td>
                                              {$userInfo['email']}
                                          </td>
                                          <td>
                                              {$userInfo['mobile']}
                                          </td>   
                                          <td>
                                              {$firstSite['name']}            
                                                    &nbsp;
                                          </td>
                                          <td>
                                              $workgroupHtml            
                                                    &nbsp;
                                          </td>
                                          <td>
                                              {$invitationInfo['date_sent']}             
                                                    &nbsp;
                                          </td>
                                          <td>
                                              {$invitationInfo['date_joined']}                
                                                    &nbsp;
                                          </td>
                                          <td>                                                                                                         
                                              $action
                                          </td>
                                      </tr>
                                  ";    
                                  foreach($sites as $aSite)
                                  {                            
                                        if($count%2 ==0)
                                            $rowClass='evenRow';
                                        else         
                                            $rowClass='oddRow';
                                        ++$count;
                                        $invitationInfo=Invitation::GetSiteInvitationInfo($aSite['site_id'],$aAdministrator['administrator_id']);
                                        $workgroups=Workgroup::GetByAdministrator($aAdministrator['administrator_id'],$currentUserId,$status='active',$aSite['site_id']);
                                                         
                                        $workgroupHtml='';
                                        $br='';
                                        foreach($workgroups as $aWG)
                                        {
                                            $workgroupHtml.=$br.$aWG['name'];
                                            $br='<br>';
                                        }
                                        echo"
                                            <tr class='$rowClass'>       
                                                <td>                     
                                                    &nbsp;
                                                </td>                       
                                                <td>                                          
                                                    &nbsp;
                                                </td>
                                                <td>                                       
                                                    &nbsp;
                                                </td>
                                                <td>                                        
                                                    &nbsp;
                                                </td>   
                                                <td>{$aSite['name']}
                                                </td>
                                                <td>$workgroupHtml
                                                </td>
                                                <td>{$invitationInfo['date_sent']}
                                                </td>
                                                <td>{$invitationInfo['date_joined']}
                                                </td>
                                                <td>                                                                                                         
                                                    &nbsp;
                                               </td>
                                            </tr>
                                        ";
                                      
                                  }
                              }
                          ?> 
                   </table>

                   <!-- Dialogs -->                         
                   <div id='administratorDialog' class='icodeDialog'> hi administrator
                   </div>          
                   <div id='reinstateDialog' class='icodeDialog'>hi recp
                   </div>
                   <!-- Dialogs end-->