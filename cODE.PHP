<?php

/*
 __PocketMine Plugin__
 name=Pac - A chat Operating System
 version=0.1
 author=Legomite
 class=Pac
 apiversion=10,11
 */
/*
 *THIS PLUGIN RUNS ON...
 *  ____            _        _   __  __ _                  __  __ ____                               __                  __
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \       ___    ___    _ __  __| |_   ___   ___  __| |_
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |     / __|  / _ \  | '_ \ \_  _|  / _ \ / __| \_  _|
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/     | (__  | (_)| | | | |  | |_  |  __/ \__ \  | |__
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|         \___| \___/  |_| |_|  \___/ \___|  |___/  \___/
 *
 *
 * Created for the Pocketmine plugin contest
 */
class Pac implements Plugin {
	private $api, $message, $player;
	public function __construct(ServerAPI $api, $server = false) {
		$this -> api = $api;
		$this -> server = ServerAPI::request();
	}

	public function init() {
		$this -> settings = new Config($this -> api -> plugin -> configPath($this) . "Settings.yml", CONFIG_YAML, array("Console Notice" => "off", "Allow Document creation" => "on", "Allow Editing Documents" => "on", ));
		$this -> notice = $this -> settings -> get("Console Notice");
		$this -> creation = $this -> settings -> get("Allow Document creation");
		$this -> api -> console -> register("documentcreate", "Create a document", array($this, "cmd"));
		$this -> api -> console -> register("documentedit", "Add text to document", array($this, "cmd"));
		$this -> api -> console -> register("documentread", "Read text from the document", array($this, "cmd"));
		$this -> api -> console -> register("createfolder", "Create a folder", array($this, "cmd"));
		@mkdir($this -> api -> plugin -> configPath($this) . "Documents");
		if (file_exists($this -> api -> plugin -> configPath($this) . "Documents.yml")) {
			foreach ($DocumentsFile->getAll() as $k => $value) {
				@mkdir($this -> api -> plugin -> configPath($this) . "Documents/" . $k{0} . "/");
				$d = new Config($this -> api -> plugin -> configPath($this) . "Documents/" . $k{0} . "/" . $k . ".yml", CONFIG_YAML, $value);
				$d -> save();
			}
			@unlink($this -> api -> plugin -> configPath($this) . "players.yml");
		}

	}

	public function __destruct() {
	}

	public function cmd($cmd, $args, $issuer, $data, $event, $classname) {
		switch($cmd) {
			case "documentedit" :
				if ($args[0] == "") {
					$output = "Usage: /Documentedit <Name>-<Text>";
				} else {
					$name = implode(" ", $args);
					$msg = implode("-", $args);
					$this -> config -> Documents -> $name['Document'] = array($msg);
					$this -> api -> plugin -> writeYAML($this -> api -> plugin -> configPath($this) . ".$name.yml", $this -> config);
					$output = "You have edited a Document!";
					if ($this -> notice == "on") {
						console("[Pac] " . $issuer . " has Edited a document!");
						break;
					}
				}
			case "documentcreate" :
				if ($args[0] == "") {
					$output = "Usage: /Documentcreate <name>";
				} else {
					$name = implode(" ", $args);
					$output = "You have made a Document!";
					$d = new Config($this -> api -> plugin -> configPath($this) . "Documents/" . $name -> iusername{0} . "/" . $name . ".yml", CONFIG_YAML, array());
					if ($this -> notice == "on") {
						console("[Pac] " . $issuer . " has made a Document");
						break;
				}
				}
				}
				}
				}
