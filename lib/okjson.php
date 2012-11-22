<?php

class OKJson {
  private $project_dir;
  private $project_dirname;

  function __construct($directory='projects') {
    $this->project_dir = dirname($_SERVER["SCRIPT_FILENAME"]) . "/" . $directory;
    $this->project_dirname = $directory;
  }

  private function projects() {
    $i = 1; // todo: clean this up
    foreach($this->project_titles() as $project){
      $project_object[] = array("id" => json_encode($i),
                                "title" => json_encode($project),
                                "images" => $this->images($project),
                                "description" => $this->description($project));
      $i++;
    }
    return $project_object;
  }

  private function project_titles() {
    if (is_dir($this->project_dir)) {
      if ($handle = opendir($this->project_dir)) {
        while (false !== ($entry = readdir($handle))) {
          if ($entry != "." && $entry != "..") {
            $projects[] = $entry;
          }
        }
        closedir($handle);
        return $projects;
      } else {
        trigger_error("OKJson: OKJson cannot open $this->project_dir. Check your permissions?", E_USER_ERROR);
      }
    } else {
      trigger_error("OKJson: $this->project_dir isn't a directory", E_USER_ERROR);
    }
  }

  private function images($dir='') {
    $dir = $this->project_dir . "/" . $dir;
    $root = scandir($dir);

    foreach($root as $value) {
      if($value === '.' || $value === '..') {
        continue;
      }
      if(is_file("$dir/$value") && preg_match("/.jpg|.jpeg|.gif|.png/i",$value)){
        $p = pathinfo($value);
        $title = json_encode($p["filename"]);
        $src = json_encode("$dir/$value");
        $result[]= array("src" => "$src", "title" => "$title");
        continue;
      }

    }
    if ($result) {
      return $result;
    }
  }

  private function description($dir=''){
    $file = "projects/{$dir}/description.txt";
    if(file_exists($file)){
      $description = file_get_contents($file);
      return stripcslashes($description);
    }
  }

  public function to_json(){
    $json_root = strtolower($this->project_dirname);
    return json_encode(array("$json_root" => $this->projects()));
  }

}
