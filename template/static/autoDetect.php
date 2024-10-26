    
    <div class="col-12 col-md-4 col-lg-6">
        <div class="mb-3">
            <span class="h5">Auto Detect</span>
            <span class="text-danger d-none h6" id="duplicateQuestion"> ( Exists ) </span>
            <button class="btn border btn-sm ms-3 float-end d-none" id="clearList">Clear List</button>
            <span id="newQuestionCount" class="ms-3 small float-end"></span>
        </div>
        <div class="mb-3">
            <textarea class="form-control" id="autoDetectQuestion" rows="12"></textarea>
        </div>
        <div class="mt-5 mb-2">
            <div class="d-flex bd-highlight">
                <div class="flex-fill bd-highlight">
                    <button class="btn border btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseId">Auto detect question list</button>
                </div>
                <div class="bd-highlight">
                    <span class="ps-2 pe-2 small">
                        <input class="form-check-input" type="checkbox" value="" name="shuffle">
                        <label class="form-check-label">Shuffle</label>
                    </span>
                </div>
            </div>
            
        </div>
        <div class="collapse" id="collapseId">
            <textarea class="form-control" id="autoDetectQuestionList" rows="14"></textarea>
        </div>
    </div>

    <script>

        // catch question list
        newQuestionList = localStorage.getItem('newQuestionList') ? JSON.parse(localStorage.getItem('newQuestionList')) : [];
        if (newQuestionList.length) {
            $("#autoDetectQuestion").val(newQuestionList[0]);
            alert(newQuestionList.length);
            newQuestionList.shift();
            if (newQuestionList.length) {
                localStorage.setItem('newQuestionList', JSON.stringify(newQuestionList));
            }else
                localStorage.removeItem('newQuestionList');

            $("#newQuestionCount").text(newQuestionList.length + " questions on queue");
            $("#clearList").removeClass('d-none');
        }

        // autoDetect Question list
        $("#autoDetectQuestionList").change(function () {

            // filter list
            ansWords = ["answer: option", "answer", "Answer", "ans key", "option", "ans", "Ans", "ANS"];
            list = $("#autoDetectQuestionList").val().trim().split("\n");
            newList = '';
            list.forEach(line => {
                line = line.trim();
                if(line){
                    ans_flag = false;
                    ansWords.forEach(element => {
                        if (line.indexOf(element) == 0)
                            ans_flag = true;
                    });

                    if(ans_flag) newList = newList + line + "\n\n";
                    else newList = newList + line + "\n";
                }
            });

            // get question array
            newQuestionList = newList.split("\n\n");

            if ($('input[name=shuffle]:checked')){
                newQuestionList = shuffle(newQuestionList);
            }

            if (newQuestionList.length) {
                $("#autoDetectQuestionList").val("");
                $("#autoDetectQuestion").val(newQuestionList[0]);
                newQuestionList.shift();
                $("#newQuestionCount").text(newQuestionList.length + " question in list");
                localStorage.removeItem('newQuestionList');
                localStorage.setItem('newQuestionList', JSON.stringify(newQuestionList));
                setQuestion ();
                $("#clearList").removeClass('d-none');
            }
        });

        // clear question list
        $("#clearList").click(function () {
            localStorage.removeItem('newQuestionList');
            newQuestionList = [];
            $("#newQuestionCount").text(newQuestionList.length + " question there");
        });


        // ---------------------------------------------------------------------------------------------------------




        // autoDetectQuestion
        //option1Match = ["(A)", "(a)", "A)", "a)", "A.", "a.", "A -", "a -", "1.", "১.", "(ক)"];
        //option2Match = ["(B)", "(b)", "B)", "b)", "B.", "b.", "B -", "b -", "2.", "২.", "(খ)"];
        //option3Match = ["(C)", "(c)", "C)", "c)", "C.", "c.", "C -", "c -", "3.", "৩.", "(গ)"];
        //option4Match = ["(D)", "(d)", "D)", "d)", "D.", "d.", "D -", "d -", "4.", "৪.", "(ঘ)"];
        //optionAnsMatch = ["answer: option", "answer", "ans key", "option", "ans"];

        var option1Match = ["(A)", "(a)", "A)", "a)", "A.", "a.", "A -", "a -", "1.", "1)", "(1)", "১.", "(ক)"];
        var option2Match = ["(B)", "(b)", "B)", "b)", "B.", "b.", "B -", "b -", "2.", "2)", "(2)", "২.", "(খ)"];
        var option3Match = ["(C)", "(c)", "C)", "c)", "C.", "c.", "C -", "c -", "3.", "3)", "(3)", "৩.", "(গ)"];
        var option4Match = ["(D)", "(d)", "D)", "d)", "D.", "d.", "D -", "d -", "4.", "4)", "(4)", "৪.", "(ঘ)"];
        var optionAnsMatch = ["answer: option", "answer", "ans key", "option", "ans"];

        // on change
        $("#autoDetectQuestion").change(function () { 

            var qstText = '';
            var qstArr = $("#autoDetectQuestion").val().split("\n");
            qstArr = jQuery.grep(qstArr, function(value) {
                return $.trim(value).length!=0;
            });
            for (i = 0; i < qstArr.length; i++) { qstText += qstArr[i] + '\n' ; }
            $("#autoDetectQuestion").val(qstText);

            setQuestion(); 
        });

        // on reload
        qst = $("#autoDetectQuestion").val();
        if(qst.length>0) { setQuestion (); }

        function setQuestion () {
            var text = $("#autoDetectQuestion").val().split("\n");            
            var questionText = '';
            var i = 0;
            for (i = 0; i < text.length; i++) {
                if (isOption(text[i], text[i + 1]))
                    break;
                questionText += '\n' + text[i];
            };

            $("#questionStr").val(questionText.trim());
            checkDuplicateQuestion(questionText.trim());

            $("#option1").val(validateString(text[i], "option1"));
            $("#option2").val(validateString(text[++i], "option2"));
            $("#option3").val(validateString(text[++i], "option3"));
            $("#option4").val(validateString(text[++i], "option4"));

            ans_flag = false;
            ans_number = 0;
            ans = validateString(text[++i], "ans").replace(/[&\/\\#,+()$~%.'":*?<>{}=_-]/g, '').trim();
            if (ans == 1 ||  ans == 'a' || ans == '১' || ans == 'ক') { 
                $('#ansOption option[value="1"]').prop('selected', true); 
                ans_flag = true; 
                ans_number = 1;
            }
            if (ans == 2 ||  ans == 'b' || ans == '২' || ans == 'খ') { 
                $('#ansOption option[value="2"]').prop('selected', true); 
                ans_flag = true; 
                ans_number = 2;
            }
            if (ans == 3 ||  ans == 'c' || ans == '৩' || ans == 'গ') { 
                $('#ansOption option[value="3"]').prop('selected', true); 
                ans_flag = true; 
                ans_number = 3;
            }
            if (ans == 4 ||  ans == 'd' || ans == '৪' || ans == 'ঘ') { 
                $('#ansOption option[value="4"]').prop('selected', true); 
                ans_flag = true; 
                ans_number = 4;
            }

            if (ans_flag) {
                $("#autoDetectQuestion").removeClass("border-danger");
                $("#autoDetectQuestion").addClass("border-success");
                $("#qstOptions input").removeClass("bg-option");
                $("#option"+ans_number).addClass("bg-option");
            } else {
                $("#autoDetectQuestion").removeClass("border-success");
                $("#autoDetectQuestion").addClass("border-danger");
            }

        }

        // validate text
        function validateString(str, selector) {
            result = undefined;
            badTextArray = [];
            str = str.trim();
            if (selector == 'option1') badTextArray = option1Match;
            else if (selector == 'option2') badTextArray = option2Match;
            else if (selector == 'option3') badTextArray = option3Match;
            else if (selector == 'option4') badTextArray = option4Match;
            else if (selector == 'ans') badTextArray = optionAnsMatch;
            if (selector == 'ans') str = str.toLowerCase();
            
            if (str);
            badTextArray.forEach(element => {
                if (str.indexOf(element) == 0) {
                    if (!result)
                        result = str.replace(element, "").trim();
                }
            });
            //console.log(result);
            return result;
        }

        // check for option
        function isOption(line1, line2) {
            line1_flag = false;
            line2_flag = false;
            line1 = line1.trim();
            line2 = line2.trim();
            option1Match.forEach(element => {
                if (line1.indexOf(element) == 0)
                    line1_flag = true;
            });

            if (line1_flag)
                option2Match.forEach(element => {
                    if (line2.indexOf(element) == 0)
                        line2_flag = true;
                });

            if (line1_flag && line2_flag) return true;
            else return false;
        }

        // array suffel
        function shuffle(array) {
            var currentIndex = array.length,  randomIndex;
            while (0 !== currentIndex) {
                randomIndex = Math.floor(Math.random() * currentIndex);
                currentIndex--;
                [array[currentIndex], array[randomIndex]] = [
                array[randomIndex], array[currentIndex]];
            }
            return array;
        }

        // duplicte question
        function checkDuplicateQuestion(question){
            $.ajax({
                type: 'POST',
                dataType: "JSON",
                data : JSON.stringify(question),
                url: "/question/isQuestionExist",
                success: function (result) {
                    if(result) $("#duplicateQuestion").removeClass("d-none"); 
                    else $("#duplicateQuestion").addClass("d-none");
                }
            });
        }


    </script>
