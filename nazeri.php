<?php
//Include and initialize Poll class 
include 'Poll.php';
$poll = new Poll;

//Check whether vote is submitted
if(isset($_POST['voteSubmit'])){
    $voteData = array(
        'poll_id' => $_POST['pollID'],
        'poll_option_id' => $_POST['voteOpt']
    );
    //Submit vote by Poll class
    $voteSubmit = $poll->vote($voteData);
    if($voteSubmit){ 
        //store in $_COOKIE to signify the user has voted
        setcookie($_POST['pollID'], 1, time()+60*60*24*365);
        $statusMsg = 'Your vote has been submitted successfully.';
    }else{
        $statusMsg = 'Your vote already had submitted.';
    }
}
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="UTF-8" />
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css"/>

</head>
<body>
    <div class="container-fluid">
        <?php
            //Get poll and options data
            $pollData = $poll->getPolls();
        ?>
        <p class="text-center"><?php echo !empty($statusMsg)? $statusMsg : ''; ?></p>

        <form action="" method="post" name="pollFrm">
            <h3 class="text-center"><?php echo $pollData['poll']['subject']; ?></h3>
            <ul>
                <?php foreach($pollData['options'] as $opt){
                    echo '<li><input type="radio" name="voteOpt" value="'.$opt['id'].'" >'.$opt['name'].'</li>';
                } ?>
            </ul>
            <input type="hidden" name="pollID" value="<?php echo $pollData['poll']['id']; ?>">
            <div class="row">
                <div class="col-xs-2">
                    <input type="submit" name="voteSubmit" class="btn btn-success" value="Vote">
                </div>
                <div class="col-xs-2">
                    <a class="btn btn-info" href="results.php?pollID=<?php echo $pollData['poll']['id']; ?>">Results</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>