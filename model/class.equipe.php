<?php
class Equipe {
    private $id;
    private $projectID;
    private $scrumMasterID;

    public function __construct($projectID, $scrumMasterID) {
        $this->projectID = $projectID;
        $this->scrumMasterID = $scrumMasterID;
    }

    // Add getters and setters as needed
}
