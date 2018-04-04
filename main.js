//(function () {
    
    'use strict';

    let php = 'main.php',                                                       // Path to PHP file
        req = new XMLHttpRequest(),                                             // New AJAX request Object
        formData = new FormData(),                                              // Form Data for AJAX request
        loading = false,                                                        // Decides whether loading bar is shown (false = hidden)
        loadingBar = document.getElementById('loader'),                         // Load bar element
        upload = document.querySelector('input[type="file"]'),
        firstnames = document.getElementsByName('firstnames'),                  // HTML element for firstname Field
        surname = document.getElementsByName('lastname')[0],                    // HTML element for lasttname Field
        nationality = document.getElementsByName('nationality')[0],             // HTML element for NationalityField
        email = document.getElementsByName('email')[0],                         // HTML element for Email Field
        tel = document.getElementsByName('telephone')[0],                       // HTML element for Telephone Field
        houseNo = document.getElementsByName('houseNo')[0],                     // HTML element for HouseNo Field
        street = document.getElementsByName('street')[0],                       // HTML element for Street Field
        city = document.getElementsByName('city')[0],                           // HTML element for City Field
        postcode = document.getElementsByName('postcode')[0],                   // HTML element for Postcode Field
        dob = document.getElementsByName('birthdate')[0],                       // HTML element for DOB Field
        liscenceType = document.getElementsByName('typeOfLiscence')[0],         // HTML element for Liscence details
        liscenceIssuer = document.getElementsByName('issuingCountry')[0],
        summary = document.getElementsByName('personalitySummary')[0],          // HTML element for summary Field
        professionalExpField = document.getElementById('professionalExp'),      // HTML element for Professional Exp Field
        educationField = document.getElementById('education'),                  // HTML element for Qualifications / Education Field
        languagesField = document.getElementById('languages'),                  // HTML element for Language Skills Field
        programmesField = document.getElementById('computerSkills'),            // HTML element for Computer Programmes Skills Field
        addPosition = document.getElementById('addAnotherPosition'),            // HTML Button element for adding Professional Exp
        addQualification = document.getElementById('addAnotherQualification'),  // HTML Button element for adding Qualifications
        addLanguage = document.getElementById('addLanguage'),                   // HTML Button element for adding Languages
        addProgramme = document.getElementById('addProgramme'),                 // HTML Button element for adding Computer Programmes
        messagesModal = document.getElementById('messagesModal'),               // Div element to display messages in
        
        //CV = {},                                                              // Initial CV Object to filled by user info. Need to uncomment when test data below is deleted.
                                                                                // Temporary CV Object info for testing, this will be overwritten if form is submitted and should be removed before deploy!!
        CV = {
            address:        {houseNo: "11", street: "Weserstraße", city: "Berlin", postcode: "12047"},
            dob:    	   "1985-12-02",
            education:      [
                                {startDate: "2005-09", endDate: "2005-09", qualification: "BA Honours Media Production", institute: "Northumbria Univeristy", grade: "First"}, 
                                {startDate: "2004-09", endDate: "2004-09", qualification: "Art Foundation", institute: "Leeds Art College", grade: "Pass"},
                                {startDate: "2004-09", endDate: "2004-09", qualification: "Art Foundation", institute: "Leeds Art College", grade: "Pass"},
                                {startDate: "2004-09", endDate: "2004-09", qualification: "Art Foundation", institute: "Leeds Art College", grade: "Pass"},
                                {startDate: "2004-09", endDate: "2004-09", qualification: "Art Foundation", institute: "Leeds Art College", grade: "Pass"}
                            ],
            email:          "onlinegurl@gmail.com",
            firstname:      "Jessica",
            languages:      [
                                {Language: "German", skillLevel: "conversational"},
                                {Language: "English", skillLevel: "native"}
                            ],
            lastname:       "Greene",
            liscence:       {type: "B", issuer: "UK"},
            nationality:    "Birtish",
            professionExp:  [
                                {startDate: "2012-09", endDate: "0007-05", company: "THE BARN GmbH", position: "Head Roaster & Production Managaer"},
                                {startDate: "2006-04", endDate: "2011-10", company: "Freelance (Self Employed)", position: "Camera Assistant"},
                                {startDate: "2006-04", endDate: "2011-10", company: "Freelance (Self Employed)", position: "Camera Assistant"},
                                {startDate: "2006-04", endDate: "2011-10", company: "Freelance (Self Employed)", position: "Camera Assistant"},
                                {startDate: "2006-04", endDate: "2011-10", company: "Freelance (Self Employed)", position: "Camera Assistant"},
                                {startDate: "2006-04", endDate: "2011-10", company: "Freelance (Self Employed)", position: "Camera Assistant"}
                                            ],
            programmes:     [
                                {programme: "PHP", skillLevel: "intermediate"},
                                {programme: "JavaScript", skillLevel: "intermediate"},
                                {programme: "Python", skillLevel: "beginner"},
                                {programme: "", skillLevel: "beginner"}
                            ],
            summary:        "I am a hard working, reliable individual who has had the opportunity to gain many skills through exciting and varying jobs, volunteer work and hobbies. I welcome any new challenge or experience.",
            tel:            "+4917639956647",
        },
                                                                                //Create and Add Professional Exp Class
        AddprofessionalExp = function() {
            var ID = professionalExpField.childElementCount + 1,                // Id of skill
                                                                                // HTML Content for sector
                html = '<!-- Date --><hr><span class="removeSection"> &times;</span> <div class="row"><div class="col-25"><label >Start Date:</label></div> <div class="col-75"><input type="month" ></div></div> <div class="row"><div class="col-25"><label >End Date:</label></div> <div class="col-75"> <input type="month" ></div></div><!-- Company --> <div class="row"><div class="col-25"><label>Company:</label></div> <div class="col-75"><input type="text" autocomplete="organization"></div></div> <!-- Position --> <div class="row"><div class="col-25"><label>Position:</label></div> <div class="col-75"> <input type="text" autocomplete="position" ></div></div></div>',
                deleteBtn;
            
                                                                                // Create new Entry Field to be appended to section with above HTML
            function createNewField(ID) {                                     
                var entry = document.createElement('DIV');
                entry.className = 'positions';
                entry.innerHTML = html;
                
                var startdate = "startdate_p" + ID,
                    enddate = "enddate_p" + ID,
                    company = "company_p" + ID,
                    position = "position_p" + ID,
                    deleteBtn = entry.getElementsByClassName('removeSection')[0],
                    startdateLabel = entry.getElementsByTagName('label')[0],
                    startdateInput = entry.getElementsByTagName('input')[0],
                    enddateLabel = entry.getElementsByTagName('label')[1],
                    enddateInput = entry.getElementsByTagName('input')[1],
                    companyLabel = entry.getElementsByTagName('label')[2],
                    companyInput = entry.getElementsByTagName('input')[2],
                    positionLabel = entry.getElementsByTagName('label')[3],
                    positionInput = entry.getElementsByTagName('input')[3];
                
                // Set label for and Input name for each field according to ID
                startdateLabel.setAttribute("for", startdate);
                startdateInput.setAttribute("name", startdate);
                enddateLabel.setAttribute("for", enddate);
                enddateInput.setAttribute("name", enddate);
                companyLabel.setAttribute("for", company);
                companyInput.setAttribute("name", company);
                positionLabel.setAttribute("for", position);
                positionInput.setAttribute("name", position);
                
                function removeSection(e){
                    professionalExpField.removeChild(this.parentNode);
                }
                                                                            
                deleteBtn.addEventListener('click', removeSection);             // Add Event listener to delete the section if no longer needed (Permanent - no warning)
                professionalExpField.appendChild(entry);                        // Add element to HTML
            }
            createNewField(ID);                                                 // Run CreateNewField Function at end of Class
        },  
                                                                                //Create and Add Qualification Class
        AddQualitifcation = function() {
            var ID = educationField.childElementCount + 1,                      // Id of skill
                                                                                // HTML Content for sector
                html = '<!-- Date --> <hr><span class="removeSection"> &times;</span><div class="row"> <div class="col-25"> <label >Start Date:</label></div> <div class="col-75"> <input type="month"></div></div> <div class="row"> <div class="col-25"> <label for="enddate">End Date:</label> </div> <div class="col-75"><input type="month"></div></div> <!-- Qualification --> <div class="row"> <div class="col-25"> <label>Qualification:</label></div> <div class="col-75"> <input type="text" ></div></div> <div class="row"> <!-- Institute --> <div class="col-25"> <label >Educational Institute:</label></div> <div class="col-75"> <div class="col-50"> <input type="text" ></div> <!-- Grade --> <div class="grade col-25"><label >Grade:</label></div> <div class="col-25"> <input type="text" ></div>';
            
                                                                                // Create new Entry Field to be appended to section with above HTML
            function createNewField(ID) {
                var entry = document.createElement('DIV');
                entry.className = 'qualitfications';
                entry.innerHTML = html;
                
                var startdate = "startdate_e" + ID,
                    enddate = "enddate_e" + ID,
                    qualification = "qualification_e" + ID,
                    institute = "institute_e" + ID,
                    grade = "grade_e" + ID,
                    deleteBtn = entry.getElementsByClassName('removeSection')[0],
                    startdateLabel = entry.getElementsByTagName('label')[0],
                    startdateInput = entry.getElementsByTagName('input')[0],
                    enddateLabel = entry.getElementsByTagName('label')[1],
                    enddateInput = entry.getElementsByTagName('input')[1],
                    qualificationLabel = entry.getElementsByTagName('label')[2],
                    qualificationInput = entry.getElementsByTagName('input')[2],
                    instituteLabel = entry.getElementsByTagName('label')[3],
                    instituteInput = entry.getElementsByTagName('input')[3],
                    gradeLabel = entry.getElementsByTagName('label')[4],
                    gradeInput = entry.getElementsByTagName('input')[4];
                
                                                                                // Set label for and Input name for each field according to ID
                startdateLabel.setAttribute("for", startdate);
                startdateInput.setAttribute("name", startdate);
                enddateLabel.setAttribute("for", enddate);
                enddateInput.setAttribute("name", enddate);
                qualificationLabel.setAttribute("for", qualification);
                qualificationInput.setAttribute("name", qualification);
                instituteLabel.setAttribute("for", institute);
                instituteInput.setAttribute("name", institute);
                gradeLabel.setAttribute("for", grade);
                gradeInput.setAttribute("name", grade);
                
                function removeSection(e){
                    educationField.removeChild(this.parentNode);
                }
                                                                            
                deleteBtn.addEventListener('click', removeSection);             // Add Event listener to delete the section if no longer needed (Permanent - no warning)
                
                educationField.appendChild(entry);                              // Add element to HTML
            }
            createNewField(ID);                                                 // Run CreateNewField Function at end of Class
        },
                                                                                //Create and Add Language Class
        AddLanguage = function() {
            var ID = languagesField.childElementCount + 1,                      // Id of skill
                                                                                // HTML Content for sector
                html = '<hr><span class="removeSection"> ×</span> <div class="row"><div class="col-25"><label for="language_l2">Language:</label> </div><div class="col-75"><div class="col-50"><input type="text" name="language_l2"></div><div class="col-50"> <!-- Skill Level --> <label for="languageSkillLevel_l2">Skill Level:</label> <select name="languageSkillLevel_l2"> <option value="beginner">Beginner</option> <option value="conversational">Conversational</option> <option value="business">Business</option> <option value="fluent">Fluent</option> <option value="native">Native</option> </select></div></div></div>',
                deleteBtn;
            
                                                                                // Create new Entry Field to be appended to section with above HTML
            function createNewField(ID) {
                var entry = document.createElement('DIV');
                entry.className = 'languages';
                entry.innerHTML = html;
                
                var language = "language_l" + ID,
                    skillLevel = "languageSkillLevel_l" + ID,
                    deleteBtn = entry.getElementsByClassName('removeSection')[0],
                    languageLabel = entry.getElementsByTagName('label')[0],
                    languageInput = entry.getElementsByTagName('input')[0],
                    skillLevelLabel = entry.getElementsByTagName('label')[1],
                    skillLevelInput = entry.getElementsByTagName('select')[0];
                
                // Set label for and Input name for each field according to ID
                languageLabel.setAttribute("for", language);
                languageInput.setAttribute("name", language);
                skillLevelLabel.setAttribute("for", skillLevel);
                skillLevelInput.setAttribute("name", skillLevel);
                
                function removeSection(e){
                   languagesField.removeChild(this.parentNode);
                }
                                                                            
                deleteBtn.addEventListener('click', removeSection);             // Add Event listener to delete the section if no longer needed (Permanent - no warning)
                
                languagesField.appendChild(entry);                              // Add element to HTML
            }
            createNewField(ID);                                                 // Run CreateNewField Function at end of Class
        },
                                                                                // Create and Add Programme Class
        AddProgramme = function() {
            var ID = programmesField.childElementCount + 1,                     // Id of skill
                                                                                // HTML Content for sector
                html = '<hr><span class="removeSection"> &times;</span><div class="row"><div class="col-25"><label>Computer programme:</label></div><div class="col-75"><div class="col-50"> <input type="text"> </div><div class="col-50"><!-- Skill Level --> <label>Skill Level:</label> <select> <option value="beginner">Beginner</option> <option value="intermediate">Intermediate</option> <option value="advanced">Advanced</option> </select></div></div></div>',
                deleteBtn;
            
                                                                                // Create new Entry Field to be appended to section with above HTML
            function createNewField(ID) {
                var entry = document.createElement('DIV');
                    entry.className = 'programmes';
                    entry.innerHTML = html;
                
                var programme = "programme_cp" + ID,
                    skillLevel = "programmeSkillLevel_cp" + ID,
                    deleteBtn = entry.getElementsByClassName('removeSection')[0],
                    programmeLabel = entry.getElementsByTagName('label')[0],
                    programmeInput = entry.getElementsByTagName('input')[0],
                    skillLevelLabel = entry.getElementsByTagName('label')[1],
                    skillLevelInput = entry.getElementsByTagName('select')[0];
                
                                                                                // Set label for and Input name for each field according to ID
                programmeLabel.setAttribute("for", programme);
                programmeInput.setAttribute("name", programme);
                skillLevelLabel.setAttribute("for", skillLevel);
                skillLevelInput.setAttribute("name", skillLevel);
                
                function removeSection(e){
                    programmesField.removeChild(this.parentNode);
                }
                                                                            
                deleteBtn.addEventListener('click', removeSection);             // Add Event listener to delete the section if no longer needed (Permanent - no warning)
                
                programmesField.appendChild(entry);                             // Add element to HTML
            }
            createNewField(ID);                                                 // Run CreateNewField Function at end of Class
        },
    
        CreateCV = function() {
            var cv = {},                                                        // Create CV object
                errors = 0;                                                     // Errors variable for use in checking inputted valued validity
           
            function checkInputs(input, inputType) {
                var regexDate = /^[0-9-.]+$/,
                    regexPhone = /^[\+]?[(]?[0-9]{3}[)]?[\-\s\.]?[0-9]{3}[\-\s\.]?[0-9]{4,6}$/,
                    regexEmail = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/,
                    regexText = /^[a-zA-ZäÄöÖüÜß\-\_\:\,\"\!\(\)\'\.\s]+$/,
                    regexCode = /^[a-zA-Z0-9-.]+$/,
                    output = "",
                    test;
                if (input.value !== '') {
                    switch(inputType){
                        case "date":
                            test = regexDate.test(input.value);
                            break;
                        case "phone":
                            test = regexPhone.test(input.value);
                            break;
                        case "email":
                            test = regexEmail.test(input.value);
                            break;
                        case "text":
                            test = regexText.test(input.value);
                            break;  
                        case "code":
                            test = regexCode.test(input.value);
                            break; 
                    }

                    if(test){
                        output = input.value;
                        input.removeAttribute('style');  
                    } else {
                        input.style.borderColor = '#C4372C';
                        errors += 1;
                    }
                }
                return output;
            }
            
            function errorMessage(message){
                messagesModal.innerHTML = errorMessage;
                messagesModal.setAttribute('class', 'displayMessage');
            }
        
            function fileCheck(file) {
                return true;
            }
            
            function createNameString(firstnames) {
                var i,
                    namestring = "";
                for (i=0; i < firstnames.length; i++){
                    namestring += firstnames[i].value + " ";
                }
                return namestring.trim();                                       // Return namestring with extra white space removed
            } 
            
            function collectProfessionExp(){
                var i,                                                          // Counting number value for FOR loop
                    professionalExp = [];                                       // Array to hold all Professional Exp Objects
                
                for(i=1; i < professionalExpField.childElementCount+1; i++) {
                                                                                // Create a new object to temporary contain the data for each professional Experience, this is initialised as empty after each loop
                    var newPosition = {};
                    newPosition['startDate']    = document.getElementsByName('startdate_p' + i)[0].value;
                    newPosition['endDate']      = document.getElementsByName('enddate_p' + i)[0].value;
                    newPosition['company']      = checkInputs(document.getElementsByName('company_p' + i)[0], 'text');
                    newPosition['position']     = checkInputs(document.getElementsByName('position_p' + i)[0], 'text');
                    professionalExp.push(newPosition);                          // Push new Professional Exp Object to Professional Exp Array
                }
                return professionalExp;                                         // Return Array with all Professional Exp Objects inside it
            }
            
            function collectEducation(){
                var i,                                                          // Counting number value for FOR loop
                    education = [];                                             // Array to hold all Education Objects
                                                                                // Create a new object to temporary contain the data for each professional Experience, this is initialised as empty after each loop
                for(i=1; i < educationField.childElementCount+1; i++) {
                    var newQualification = {};
                    newQualification['startDate']  = document.getElementsByName('startdate_e' + i)[0].value;
                    newQualification['endDate']    = document.getElementsByName('startdate_e' + i)[0].value;
                    newQualification['qualification']= checkInputs(document.getElementsByName('qualification_e' + i)[0], 'text');
                    newQualification['institute']  = checkInputs(document.getElementsByName('institute_e' + i)[0], 'text');
                    newQualification['grade']      = checkInputs(document.getElementsByName('grade_e' + i)[0], 'text');
                    education.push(newQualification);                           // Push new Professional Exp Object to Professional Exp Array
                }
                return education;                                               // Return Array with all Professional Exp Objects inside it
            }
            
            function collectLanguages(){
                var i,                                                          // Counting number value for FOR loop
                    languages = [];                                             // Array to hold Language Objects
                                                                                // Create a new object to temporary contain the data for each Language, this is initialised as empty after each loop
                for(i=1; i < languagesField.childElementCount+1; i++) {
                    var newLanguage = {};
                    newLanguage['Language']      = checkInputs(document.getElementsByName('language_l' + i)[0], 'text');
                    newLanguage['skillLevel']    = document.getElementsByName('languageSkillLevel_l' + i)[0].value;
                    languages.push(newLanguage);                                // Push new Language Object to Languages Array
                }
                return languages;                                               // Return Array with all Professional Exp Objects inside it
            }
            
            function collectComputerSkills(){
                var i,                                                          // Counting number value for FOR loop
                    computerSkills = [];                                        // Array to hold all Computer Skills Objects
                                                                                // Create a new object to temporary contain the data for each Computer Skill, this is initialised as empty after each loop
                for(i=1; i < programmesField.childElementCount+1; i++) {
                    var newProgramme = {};
                    newProgramme['programme']      = checkInputs(document.getElementsByName('programme_cp' + i)[0], 'text');
                    newProgramme['skillLevel']     = document.getElementsByName('programmeSkillLevel_cp' + i)[0].value;
                    computerSkills.push(newProgramme);                          // Push new Computer Skills Object to Computer Skills Array
                }
                return computerSkills;                                          // Return Array with all Computer Skills Objects inside it
            }

            cv['firstname']     = createNameString(firstnames);                 // Set all fields in the CV Object
            cv['lastname']      = checkInputs(surname, 'text'); 
            cv['nationality']   = nationality.value;
            cv['email']         = checkInputs(email, 'email');
            cv['tel']           = checkInputs(tel, 'phone');
            cv['address']       = 
                                {
                                    "houseNo":  checkInputs(houseNo, 'code'),
                                    "street":   checkInputs(street, 'text'),
                                    "city":     checkInputs(city, 'text'),
                                    "postcode": checkInputs(postcode, 'code')
                                };
            cv['dob']           = dob.value;
            cv['liscence']      =   
                                {
                                    "type":     liscenceType.value,
                                    "issuer":   liscenceIssuer.value
                                };
            cv['summary']       = checkInputs(summary, 'text');
            cv['professionExp'] = collectProfessionExp();
            cv['education']     = collectEducation();
            cv['languages']     = collectLanguages();
            cv['programmes']    = collectComputerSkills();
                                                                                // Check no invalid values entered & return CV / error message
                                                                                //checks if any errors have been raised and either returns CV Object or an error message
            if (errors === 0) {
                    return cv;                                                  // Return CV Object
            } else {
                var message = "Please check your inputed Data and correct fields marked in red";
                window.console.log(message);
                errorMessage(message);
                return 'error';
            }
        };

    function sendRequest(type, data, file) {
        formData.set('request', type);                                          // Request Type (incase multiple)
        formData.set('data', JSON.stringify(data));                             // CV in this case
                                                                                // Set file item with uploaded photo info if given
        if(file) {
            formData.set('photograph', file, file.name);
        } else {
            formData.set('photograph', '');
        }
        req.open('POST', php, true);                                            // Connection to PHP open
        req.send(formData);                                                     //  Send the Request with CV stored in it
    }
    
    function RequestState(evt) {
                                                                                //  If request is finished and response given (readystate = 4) and uploaded (status = 200)
        if (evt.target.readyState === 4 && evt.target.status === 200) {
            messagesModal.getElementsByTagName('div')['requestResponse'].innerHTML = this.responseText;
        }
     }

    function displayCVToSend() {
        var html = '<div id="pdfPreview"><h2>Preview of your CV</h2><p>Click continue to send this version via email or click cancel to return</p><object width="400" height="600" type="application/pdf" data="pdf_cv.pdf#zoom=40" id="pdf_content" alt="Preview of your CV"><p>System Error - This PDF cannot be displayed, please contact IT.</p></object><span class="buttonContainers"><button id="cancel"> Cancel</button><button id="continue">Continue</button></span></div><div id="sendViaEmail" class="hide"><h2>Please enter your email and we will send you the PDF version of your CV</h2><input type="text" id="emailAdd" name="email" placeholder="Your Email.."><button id="sendEmail"></button></div><div id="requestResponse"></div>';
        
        messagesModal.setAttribute('class','display');
        
        setTimeout(function(){
            loading = false;                                                        // Set loading to false to hide loading bar again
            loadingBar.setAttribute('class', 'hide');
            messagesModal.innerHTML = html;
            messagesModal.getElementsByTagName('button')['cancel'].addEventListener('click', function(){
                //messagesModal.innerHTML="";
                messagesModal.setAttribute('class', 'hide');

            });

            messagesModal.getElementsByTagName('button')['continue'].addEventListener('click', function(){
                var emailInput = messagesModal.getElementsByTagName('input')['email'];
                messagesModal.getElementsByTagName('div')['pdfPreview'].setAttribute('class', 'hide');
                messagesModal.getElementsByTagName('div')['sendViaEmail'].setAttribute('class', 'display');
                messagesModal.getElementsByTagName('button')['sendEmail'].addEventListener('click', function(e){
                    e.preventDefault();
                    sendRequest(2, emailInput.value);
                    messagesModal.getElementsByTagName('div')['sendViaEmail'].setAttribute('class', 'hide');
                });

            });
        }, 5000);
        
    }

    req.addEventListener('readystatechange', RequestState);                     // Ready State Change Event to collect response if sent

    addPosition.addEventListener('click', function(e){                          // Click Event to add new Professional Exp
        e.preventDefault();
        if (professionalExpField.childElementCount < 9){
            AddprofessionalExp();
        } else {
            window.console.log("maximum amount of Positions added");
        }
    });
                                                                                // Click Event to add new Professional Exp
    addQualification.addEventListener('click', function(e){
        e.preventDefault();
        if (educationField.childElementCount < 9){
            AddQualitifcation();
        } else {
            window.console.log("maximum amount of Positions added");
        }
    });
                                                                                // Click Event to add new Language Skill
    addLanguage.addEventListener('click', function(e){
        e.preventDefault();
        if (languagesField.childElementCount < 9){
            AddLanguage();
        } else {
            window.console.log("maximum amount of Positions added");
        }
    });
                                                                                // Click Event to add new Computer Programme
    addProgramme.addEventListener('click', function(e){
        e.preventDefault();
        if (programmesField.childElementCount < 9){
            AddProgramme();
        } else {
            window.console.log("maximum amount of Positions added");
        }
    });
                                                                                // Click Event to Test creation of CV
    document.getElementById('submit').addEventListener('click', function(e){
        loading = true;                                                        // Set loading to true to display loading bar
        loadingBar.setAttribute('class', 'display');
        e.preventDefault();
        CV = CreateCV();
        var file = upload.files[0];                                             // Retrieve photo need to check it here also!!
        if(CV != 'error') {
            if(file) {
                sendRequest(1, CV, file);
            } else {
                sendRequest(1, CV);
            }
        }
                                                                                // Function to scroll to top once submit is pressed.
        (function smoothscroll(){
            var currentScroll = document.documentElement.scrollTop || document.body.scrollTop;
            if (currentScroll > 0) {
                 window.requestAnimationFrame(smoothscroll);
                 window.scrollTo (0,currentScroll - (currentScroll/5));
            }
        })();
        displayCVToSend();
    });

//});