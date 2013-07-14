<?php
	require_once('connection.php');
	
	
    class Team{
    	public  $Size;
		public  $Name;
		public $icon_url;
		public $Captain;
		public $NumofCaptains;
		public  $numOfSubs;
		public  $Team;
		
		function __construct($n){
			$con = connectToDB();
			$this->Name = $n;
			$results = mysqli_query($con,"SELECT * FROM Teams WHERE Name='" . $n . "'");
			$row = mysqli_fetch_array($results);
			$this->Captain =  preg_split("/[|]/", $row['Captain']);
			$this->NumofCaptains = count($this->Captain);
			if($row['Team']==''){
				$this->Team = array();
			}
			else{
				$this->Team =  preg_split("/[|]/", $row['Team']);
			}
			
			$this->Size = count($this->Team);
		}
		
		function addMember($TeamMember){
			$con = connectToDB();
			if(($this->Size < 11)&&!in_array($TeamMember, $this->Team)){
				$this->Size++;
				$results = mysqli_query($con,"SELECT * FROM Teams WHERE Name='" . $this->Name . "'");
				$row = mysqli_fetch_array($results);
				if($this->Size==0){
					$NewTeam = $TeamMember;
				}
				else{
					$NewTeam = $row['Team'] . "|" . $TeamMember;
				}
				
				array_push($this->Team, $TeamMember);
				$stmt = $con->prepare("UPDATE Teams SET Team = ? WHERE Name='" . $this->Name . "'");
				$stmt->bind_param('s', $NewTeam);
				$stmt->execute();
				$stmt->close();
			}
			elseif(in_array($TeamMember, $this->Team)){
				echo '<br />' . $TeamMember. ' is already on this team';
			}
			else {
				echo "<br />Team is full";
			}
		}
		
		function removeMember($TeamMember){
			$con = connectToDB();
			$results = mysqli_query($con,"SELECT * FROM Teams WHERE Name='" . $this->Name . "'");
			$row = mysqli_fetch_array($results);
			if(in_array($TeamMember, $this->Team)&&$this->Size>1){
				$this->Team = array_diff($this->Team, array($TeamMember));
				$NewTeam = $this->Team[0];
				foreach($this->Team as $New){
					if($New != $NewTeam){
						$NewTeam = $NewTeam . '|' . $New;
					}
					
				}
				$stmt = $con->prepare("UPDATE Teams SET Team = ? WHERE Name='" . $this->Name . "'");
				$stmt->bind_param('s', $NewTeam);
				$stmt->execute();
				$stmt->close();
			}
			elseif($this->Size==1&&in_array($TeamMember, $this->Team)){
				$this->Team = array();
				$stmt = $con->prepare("UPDATE Teams SET Team = '' WHERE Name='" . $this->Name . "'");
				$stmt->execute();
				$stmt->close();
			}
		}
		function promoteToCaptain($TeamMember){
			$con = connectToDB();
			$results = mysqli_query($con,"SELECT * FROM Teams WHERE Name='" . $this->Name . "'");
			$row = mysqli_fetch_array($results);
			echo $this->NumofCaptains;
			if(in_array($TeamMember, $this->Team)&&$this->NumofCaptains<3){
				$this->NumofCaptains++;
				$this->removeMember($TeamMember);
				$NewCaptain = $row['Captain'] . "|" . $TeamMember;
				array_push($this->Captain, $TeamMember);
				$stmt = $con->prepare("UPDATE Teams SET Captain = ? WHERE Name='" . $this->Name . "'");
				$stmt->bind_param('s', $NewCaptain);
				$stmt->execute();
				$stmt->close();
			}
		}
		function demoteToMember($TeamMember){
			$con = connectToDB();
			$results = mysqli_query($con,"SELECT * FROM Teams WHERE Name='" . $this->Name . "'");
			$row = mysqli_fetch_array($results);
			
			if(in_array($TeamMember, $this->Captain)&&$this->Captain>1){
				$this->Captain = array_diff($this->Captain, array($TeamMember));
				print_r($this->Captain);
				$x=0;
				while($NewCaptain==null){
					$NewCaptain = $this->Captain[$x];
					$x++;
				}
				
				foreach($this->Captain as $New){
					if($New != $NewCaptain){
						$NewCaptain = $NewCaptain . '|' . $New;
					}
					
				}
				
				array_push($this->Team, $TeamMember);
				if($this->Size==0){
					$NewTeam = $TeamMember;
				}
				else{
					$NewTeam = $row['Team'] . "|" . $TeamMember;
				}
				
				$stmt = $con->prepare("UPDATE Teams SET Captain = ? WHERE Name='" . $this->Name . "'");
				$stmt->bind_param('s', $NewCaptain);
				$stmt->execute();
				$stmt->close();
				
				$stmt = $con->prepare("UPDATE Teams SET Team = ? WHERE Name='" . $this->Name . "'");
				$stmt->bind_param('s', $NewTeam);
				$stmt->execute();
				$stmt->close();
			}
		}
    }
	
	$asdf = new Team($_GET['name']);
	$asdf->demoteToMember('dd');
	print_r($asdf->Captain);
?>