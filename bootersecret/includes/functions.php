<?php
$getallinfo = $odb -> prepare("SELECT * FROM `siteconfig`");
$getallinfo -> execute();
$settings = $getallinfo -> fetch(PDO::FETCH_ASSOC);
class user
{
	function isAdmin($odb)
	{
		$SQL = $odb -> prepare("SELECT `rank` FROM `users` WHERE `ID` = :id");
		$SQL -> execute(array(':id' => $_SESSION['ID']));
		$rank = $SQL -> fetchColumn(0);
		if ($rank == 2)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function isStaff($odb)
	{
		$SQL = $odb -> prepare("SELECT `rank` FROM `users` WHERE `ID` = :id");
		$SQL -> execute(array(':id' => $_SESSION['ID']));
		$rank = $SQL -> fetchColumn(0);
		if ($rank == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
		function isVerified($odb)
	{
		$SQLS = $odb -> prepare("SELECT `security_question` FROM `users` WHERE `ID` = :id");
		$SQLS -> execute(array(':id' => $_SESSION['ID']));

		$SQLQ = $odb -> prepare("SELECT `answer_question` FROM `users` WHERE `ID` = :id");
		$SQLQ -> execute(array(':id' => $_SESSION['ID']));

		$SQLC = $odb -> prepare("SELECT `code_account` FROM `users` WHERE `ID` = :id");
		$SQLC -> execute(array(':id' => $_SESSION['ID']));
		
		$SQLScheck = $SQLS -> fetchColumn(0);

		$SQLQcheck = $SQLQ -> fetchColumn(0);

		$checkverify = $SQLC -> fetchColumn(0);

		if ($checkverify != "0" && $SQLQcheck != "0" && $SQLScheck != "0")
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function LoggedIn()
	{
		if (isset($_SESSION['username'], $_SESSION['ID']))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function hasMembership($odb)
	{
		$SQL = $odb -> prepare("SELECT `expire` FROM `users` WHERE `ID` = :id");
		$SQL -> execute(array(':id' => $_SESSION['ID']));
		$expire = $SQL -> fetchColumn(0);
		if (time() < $expire)
		{
			return true;
		}
		else
		{
			$SQLupdate = $odb -> prepare("UPDATE `users` SET `membership` = 0 WHERE `ID` = :id");
			$SQLupdate -> execute(array(':id' => $_SESSION['ID']));
			return false;
		}
	}
	function notBanned($odb)
	{
		$SQL = $odb -> prepare("SELECT `status` FROM `users` WHERE `ID` = :id");
		$SQL -> execute(array(':id' => $_SESSION['ID']));
		$result = $SQL -> fetchColumn(0);
		if (strlen($result) <= 1)
		{
			return true;
		}
		else
		{
			session_destroy();
			return false;
		}
	}
	function accountBalance($odb)
	{
	    $SQL = $odb -> prepare("SELECT `account_balance` FROM `users` WHERE `ID` = :id");
		$SQL -> execute(array(':id' => $_SESSION['ID']));
		return $SQL -> fetchColumn(0);
	}
	
	function addAccountBalance($odb, $amount)
	{
	    $SQLupdate = $odb -> prepare("UPDATE `users` SET `account_balance` = `account_balance` + :amount WHERE `ID` = :id");
	    $SQLupdate -> execute(array(':amount' => $amount, ':id' => $_SESSION['ID']));
	}
	
	function takeAccountBalance($odb, $amount)
	{
	    $SQLupdate = $odb -> prepare("UPDATE `users` SET `account_balance` = `account_balance` - :amount WHERE `ID` = :id");
	    $SQLupdate -> execute(array(':amount' => $amount, ':id' => $_SESSION['ID']));
	}
	function addPlanWithBalance($odb, $planID)
	{
	    $getPlanInfo = $odb -> prepare("SELECT `unit`,`length` FROM `plans` WHERE `ID` = :plan");
        $getPlanInfo -> execute(array(':plan' => $planID));
        $plan = $getPlanInfo -> fetch(PDO::FETCH_ASSOC);
        $unit = $plan['unit'];
        $length = $plan['length'];
        $newExpire = strtotime("+{$length} {$unit}");
        $updateSQL = $odb -> prepare("UPDATE `users` SET `expire` = :expire, `membership` = :plan WHERE `id` = :id");
        $updateSQL -> execute(array(':expire' => $newExpire, ':plan' => $planID, ':id' => $_SESSION['ID']));
	}
}
class stats
{
    function usersOnline($odb)
    {
        $SQL = $odb -> prepare("SELECT COUNT(*) FROM `users` WHERE `lastact` > UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 5 SECOND))");
        $SQL->execute();
        return $SQL->fetchColumn(0);
    }
	function totalUsers($odb)
	{
		$SQL = $odb -> query("SELECT COUNT(*) FROM `users`");
		return $SQL->fetchColumn(0);
	}
	function totalBoots($odb)
	{
		$SQL = $odb -> query("SELECT COUNT(*) FROM `logs`");
		return $SQL->fetchColumn(0);
	}
	function runningBoots($odb)
	{
		$SQL = $odb -> query("SELECT COUNT(*) FROM `logs` WHERE `time` + `date` > UNIX_TIMESTAMP()");
		return $SQL->fetchColumn(0);
	}
	function totalnews($odb)
	{
		$SQL = $odb -> query("SELECT COUNT(*) FROM `news`");
		return $SQL->fetchColumn(0);
	}
    function totaltickets($odb)
	{
		$SQL = $odb -> query("SELECT COUNT(*) FROM `tickets`");
		return $SQL->fetchColumn(0);
	}
	function totalBootsForUser($odb, $user)
	{
		$SQL = $odb -> prepare("SELECT COUNT(*) FROM `logs` WHERE `user` = :user");
		$SQL -> execute(array(":user" => $user));
		return $SQL->fetchColumn(0);
	}
	function totalusertickets($odb, $user)
	{
		$SQL = $odb -> prepare("SELECT COUNT(*) FROM `tickets` WHERE `username` = :user");
		$SQL -> execute(array(":user" => $user));
		return $SQL->fetchColumn(0);
	}
	function serversonline($odb)
	{
		$SQL = $odb -> query("SELECT COUNT(*) FROM `servers`");
		return $SQL->fetchColumn(0);
	}
	function totalclosedtickets($user)
	{
		global $odb;
		$SQL = $odb -> prepare("SELECT COUNT(*) FROM `tickets` WHERE `username` = :user AND status = :c");
		$SQL -> execute(array(":user" => $user, ':c'=>"Closed"));
		return $SQL->fetchColumn(0);
	}
	function totalunreadtickets($user)
	{
		global $odb;
		$SQL = $odb -> prepare("SELECT COUNT(*) FROM `tickets` WHERE `username` = :user AND `read` = 0");
		$SQL -> execute(array(":user" => $user));
		return $SQL->fetchColumn(0);
	}
		function totalreadtickets($user)
	{
		global $odb;
		$SQL = $odb -> prepare("SELECT COUNT(*) FROM `tickets` WHERE `username` = :user AND `read` = 1");
		$SQL -> execute(array(":user" => $user));
		return $SQL->fetchColumn(0);
	}
    function usersforplan($odb, $plan)
	{
		$SQL = $odb -> prepare("SELECT COUNT(*) FROM `users` WHERE `membership` = :membership");
		$SQL -> execute(array(":membership" => $plan));
		return $SQL->fetchColumn(0);
	}
	function userswithplans($odb)
	{
		$SQL = $odb -> prepare("SELECT COUNT(*) FROM `users` WHERE `membership` != 0");
		$SQL -> execute();
		return $SQL->fetchColumn(0);
	}
}

function error($string)
{
return ' <div class="alert alert-danger alert-dismissable animation-bigEntrance">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                             '.$string.'
                             </div>';
}

function success($string)
{
return ' <div class="alert alert-danger alert-dismissable animation-bigEntrance">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                             '.$string.'
                             </div>';
}

function info($string)
{
return ' <div class="alert alert-danger alert-dismissable animation-bigEntrance">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                             '.$string.'
                             </div>';
}

function warning($string)
{
return ' <div class="alert alert-danger alert-dismissable animation-bigEntrance">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                             '.$string.'
                             </div>';
}
