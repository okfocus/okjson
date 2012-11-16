<?php

class OKJson {
  private $project_dir;

  function __construct($directory='projects'){
    $this->project_dir = dirname(dirname(dirname(__FILE__))) . "/" . $directory;
  }

  private function projects(){
    $i = 1; // todo: clean this up
    foreach($this->project_titles() as $project){
      $project_object[] = array("id" => json_encode($i),
                                "title" => $project,
                                "images" => $this->images($project),
                                "description" => $this->description($project));
      $i++;
    }
    return $project_object;
  }

  private function project_titles(){
    if ($handle = opendir($this->project_dir)) {
      while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
          $projects[] = $entry;
        }
      }
      closedir($handle);
      return $projects;
    }
  }

  private function images($dir=''){
    $dir = $this->project_dir . "/" . $dir;
    $root = scandir($dir);

    foreach($root as $value) {
      if($value === '.' || $value === '..') {
        continue;
      }

      if(is_file("$dir/$value") && preg_match("/.jpg|.jpeg|.gif|.png/i",$value)){
        $title = split("[.]", "$value")[0];
        $result[]= array("src" => "$dir/$value", "stuff" => "$title");
        continue;
      }

    }

    return $result;
  }

  private function description($dir=''){
    $file = "projects/{$dir}/description.txt";
    if(file_exists($file)){
      $description = file_get_contents($file);
    }
    return stripcslashes($description);
  }

  public function to_json(){
    return json_encode(array("projects" => $this->projects()));
  }

}
