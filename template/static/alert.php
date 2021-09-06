<!-- live quiz -->
<?php if( $liveQuiz) {
    if(date_create($liveQuiz['start_time']) < date_create() && date_create($liveQuiz['end_time']) > date_create()) { 
?>
    <div class="mb-3">
        <div class="d-flex alert alert-warning shadow-sm border border-warning ">
            <div class="me-3">
                <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
            </div>    
            <div class="flex-fill">
                <span class="small"><span class="small text-secondary d-block">LIVE Quiz</span></span>
                <div class="h6"><?php echo $liveQuiz['title'] ?></div>    
            </div>
            <div class="">
                <a href="/quiz/live" class="d-grid text-decoration-none">
                    <button class="btn btn-sm btn-primary">Play Now</button>
                </a>
            </div>
        </div>
    </div>

<?php 
    }
} 
?>

<!-- Important Day -->
<?php if(!empty($today)) { ?>
<div class="mb-2 container">
    <div class="row p-2 pt-3 pb-3 bg-white border rounded shadow-sm">
        <div class="col-12 col-md-4">
            <span class="h5 text-success"><?php echo $today[0]['title'] ?></span>
            <div class="small mt-2 mb-1"><?php echo date("l, d F Y", strtotime($current_date)); ?></div>
        </div>
        <div class="col-12 col-md-8">
            <!--
            <blockquote class="blockquote">
                <p class="mb-0">The Ocean: Life and Livelihoods</p>
            </blockquote>
            -->
            <span class="small text-secondary lh-sm"><?php echo $today[0]['descp'] ?></span>
        </div>
    </div>
</div>
<?php } ?>

<!-- upcoming live exam -->
<?php if( $GLOBALS["LIVE_EXAM_ID"]) { ?>
<div class="mb-3">
        <div class="d-flex alert alert-info border border-info ">  
            <div class="flex-fill">
                <span class="badge bg-success <?php echo date_create($liveExam['start_time']) < date_create() && date_create($liveExam['end_time']) > date_create()? ' ': 'd-none' ?>">Live</span>
                <div class="h6"><?php echo $liveExam['title'] ?></div> 
                <div class="small mb-0"><?php echo date_format(date_create($liveExam['start_time']),"l, dS F Y"); ?> </div>
                <span class="small m-0  me-2 text-nowrap">
                        Starts on: <?php echo date_format(date_create($liveExam['start_time']),"h:i A"); ?>
                    </span>
                    <span class="small m-0  text-nowrap">
                        Ends on: <?php echo date_format(date_create($liveExam['end_time']),"h:i A"); ?>
                    </span> 
                <div class="mt-2">

                </div>
            </div>
            <div class="text-center">
                <a href="/examcenter/live" class="text-decoration-none">
                        <button class="btn btn-sm btn-primary ps-3 pe-3">Open</button>
                </a>
            </div>
        </div>
    </div>
<?php } ?>

