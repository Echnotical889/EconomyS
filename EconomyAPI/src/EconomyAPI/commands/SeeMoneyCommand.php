<?php

namespace EconomyAPI\commands;

use EconomyAPI\EconomyAPI;

class SeeMoneyCommand extends EconomyAPICommand{
	private $plugin, $cmd;
	
	public function __construct(EconomyAPI $plugin, $cmd = "seemoney"){
		parent::__construct($cmd, $plugin);
		$this->cmd = $cmd;
		$this->setUsage("/$cmd <player>");
		$this->setDescription("See player's money");
		$this->setPermission("economyapi.command.seemoney");
	}
	
	public function execute(\pocketmine\command\CommandSender $sender, $label, array $args){
		if(!$this->getPlugin()->isEnabled()){
			return false;
		}
		if(!$this->testPermission($sender)){
			return false;
		}
		
		$player = array_shift($args);
		if(trim($player) === ""){
			$sender->sendMessage("Usage: /".$this->cmd." <player>");
			return true;
		}
		$result = $this->getPlugin()->myMoney($player);
		if($result === false){
			$sender->sendMessage($this->getPlugin()->getMessage("player-never-connected", $sender->getName(), array($player, "%2", "%3", "%4")));
			return true;
		}else{
			$sender->sendMessage($this->getPlugin()->getMessage("seemoney-seemoney", $sender->getName(), array($player, $result, "%3", "%4")));
			return true;
		}
	}
}