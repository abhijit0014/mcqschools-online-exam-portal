<?php

    include 'repository/questionRepository.php';
    include 'repository/historyRepository.php';
    include 'repository/examUserRepository.php';

    class IndexController
    {
        private $repository;
        private $historyRepository;
        private $examUserRepository;

        function __construct()
        {
            $this->repository = new QuestionRepository();
            $this->historyRepository = new HistoryRepository();
            $this->examUserRepository = new ExamUserRepository();
        }

        public function index()
        {
            $day = $this->historyRepository->getImportantDay();
            $rankList =  $this->examUserRepository->monthlyTestRank(date("Y-m-d H:i:s"),5);
            $view = new view('index');
            $view->assign('today', $day);
            $view->assign('current_date', date('Y-m-d H:i:s'));
            $view->assign('category_name', null);
            $view->assign('rankList', $rankList);
            return;
        }

        public function privacy_policy()
        {
            $view = new view('privacy_policy');
            return;
        }

        public function test()
        {
            $view = new view('test_index');
            return;
        }

    }

?>