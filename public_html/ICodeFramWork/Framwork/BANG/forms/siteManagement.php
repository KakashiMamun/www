
                   <div class='subHead'>
                        <span class='subHeadLeft'>
                              <div>Manage Sites</div>
                        </span><span class='subHeadRight'>
                        </span>
                   </div>                                                  
                   <table class='backTable' cellspacing=0 cellpadding=0>
                          <tr>     
                              <th>Sites
                              </th>        
                              <th>Linked Recipients 
                              </th>  
                              <th>Linked Administrators
                              </th>  
                              <th>Edit
                              </th>
                              <th>Action
                              </th>
                          <tr> 
                          <?php
                              $count=0;
                              foreach($sites as $aSite)
                              {             
                                  if($count%2 ==0)
                                      $rowClass='evenRow';
                                  else         
                                      $rowClass='oddRow';
                                  ++$count;                                                                                                             
                                  if($aSite['status']!='active')
                                      $action="<a href='javascript:void(0)' onclick='ReinstateOther(\"{$aSite['site_id']}\",\"site\")'>REINSTATE</a>";
                                  else if(Site::IsExpired($aSite['site_id']))                                                                     
                                      $action="<a href='index.php?page=payForSite&siteId={$aSite['site_id']}'>RENEW</a>";
                                  else
                                      $action="<a href='javascript:void(0)' onclick='SuspendOther(\"{$aSite['site_id']}\",\"site\")'>SUSPEND</a>";
                                  $countRecipient=Recipient::GetTotal($aSite['site_id'],0,0,0);
                                  $countAdministrator= Administrator::GetTotal(0,$aSite['site_id'],0,true);
                                  echo"
                                      <tr class='$rowClass'>      
                                          <td>
                                              {$aSite['name']}
                                          </td>             
                                          <td>
                                              <a href='javascript:void(0)' onclick='ShowSiteRecipientList(\"{$aSite['site_id']}\")'>$countRecipient</a>
                                          </td>   
                                          <td>
                                              <a href='javascript:void(0)' onclick='ShowSiteAdministratorList(\"{$aSite['site_id']}\")'>$countAdministrator</a>
                                          </td>   
                                          <td>                                                                                                         
                                              <a href='javascript:void(0)' onclick='ShowSiteEditForm(\"{$aSite['site_id']}\")'>EDIT</a>

                                          </td>
                                          <td>                                                                                       
                                              $action
                                          </td>
                                      </tr>
                                  ";
                              }
                          ?> 
                   </table>

                   <!-- Dialogs -->                         
                   <div id='siteDialog' class='icodeDialog'> hi site
                   </div>
                   <div id='recipientDialog' class='icodeDialog'>hi recp
                   </div>
                   <!-- Dialogs end-->