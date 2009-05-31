<?php

 function trac_login_change ($oldlogin, $newlogin)
  {
   // This simple function creates a query to change the login name of a person in the Trac 0.11.x database
   // TODO : Changing the cc fields -- ticket.cc || WHERE ticket_change.field = cc

   // ticket_change require special attention
   $query = 'UPDATE ticket_change SET oldvalue = "' . $newlogin . '" WHERE field = "owner" AND oldvalue = "' . $oldlogin . '";';
   $query .= 'UPDATE ticket_change SET newvalue = "' . $newlogin . '" WHERE field = "owner" AND newvalue = "' . $oldlogin . '";';

   // cc fields are lists, containing other logins/e-mails as well
   $query .= 'UPDATE ticket SET cc = REPLACE("cc", "' . $oldlogin .  '", "' . $newlogin . '") WHERE cc LIKE "%' . $oldlogin . '%";';

   // the rest
   $trac_affected_tables = array ( array ('attachment', 'author'),
                                   array ('component', 'owner'),
                                   array ('permission', 'username'),
                                   array ('revision', 'author'),
                                   array ('session', 'sid'),
                                   array ('session_attribute', 'sid'),
                                   array ('ticket', 'owner'),
                                   array ('ticket', 'reporter'),
                                   array ('ticket_change', 'author'),
                                   array ('wiki', 'author') );
   foreach ($trac_affected_tables as $table)
    $query .= 'UPDATE ' . $table[0] . ' SET ' . $table[1] . ' = "' . $newlogin . '" WHERE ' . $table[1] . ' = "' . $oldlogin . '";';

   return $query;
  }

?>
