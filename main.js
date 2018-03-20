//(function () {
    
    'use strict';

    var php = 'main.php',                                                   // Path to PHP file
        req = new XMLHttpRequest(),                                             // New AJAX request Object
        formData = new FormData(),                                              // Form Data for AJAX request
        firstnames = document.getElementsByName('firstnames'),                   // HTML element for firstname Field
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
        professionalExpField = document.getElementById('professionalExp'),      // HTML element for Professional Exp Field
        educationField = document.getElementById('education'),                  // HTML element for Qualifications / Education Field
        languagesField = document.getElementById('languages'),                  // HTML element for Language Skills Field
        programmesField = document.getElementById('computerSkills'),            // HTML element for Computer Programmes Skills Field
        addPosition = document.getElementById('addAnotherPosition'),            // HTML Button element for adding Professional Exp
        addQualification = document.getElementById('addAnotherQualification'),  // HTML Button element for adding Qualifications
        addLanguage = document.getElementById('addLanguage'),                   // HTML Button element for adding Languages
        addProgramme = document.getElementById('addProgramme'),                 // HTML Button element for adding Computer Programmes
        
        //CV = {},                                                              // Initial CV Object to filled by user info. Need to uncomment when test data below is deleted.
        
                                                                                // Temporary CV Object info for testing, this will be overwritten if form is submitted and should be removed before deploy!!
        CV = {
            address:        {houseNo: "11", street: "Weserstraße", city: "Berlin", postcode: "12047"},
            dob:    	   "1985-12-02",
            education:      [
                                {startDate: "2005-09-01", endDate: "2005-09-01", qualification: "BA Honours Media Production", institute: "Northumbria Univeristy", grade: "First"}, 
                                {startDate: "2004-09-01", endDate: "2004-09-01", qualification: "Art Foundation", institute: "Leeds Art College", grade: "Pass with Merit"}
                            ],
            email:          "onlinegurl@gmail.com",
            firstname:      "Jessica Jessica Jessica",
            languages:      [
                                {Language: "German", skillLevel: "conversational"},
                                {Language: "English", skillLevel: "native"}
                            ],
            lastname:       "Greene",
            liscence:       {type: "B", issuer: "UK"},
            nationality:    "Birtish",
            professionExp:  [
                                {startDate: "2012-09-01", endDate: "0007-05-01", company: "THE BARN GmbH", position: "Head Roaster & Production Managaer"},
                                {startDate: "2006-04-01", endDate: "2011-10-01", company: "Freelance (Self Employed)", position: "Camera Assistant"}
                            ],
            programmes:     [
                                {programme: "PHP", skillLevel: "intermediate"},
                                {programme: "JavaScript", skillLevel: "intermediate"},
                                {programme: "Python", skillLevel: "beginner"},
                                {programme: "", skillLevel: "beginner"}
                            ],
            summary:        "",
            tel:            "+4917639956647",
        },
                                                                                //Create and Add Professional Exp Class
        AddprofessionalExp = function() {
            var ID = professionalExpField.childElementCount + 1,                // Id of skill
                                                                                // HTML Content for sector
                html = '<!-- Date --> <label >Start Date:</label> <input type="date" > <label >End Date:</label> <input type="date" > <!-- Company --> <label>Company:</label> <input type="text" autocomplete="organization"> <!-- Position --> <label>Position:</label> <input type="text" autocomplete="position" >',
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
                
                window.console.log(entry);
                professionalExpField.appendChild(entry);
            }
            createNewField(ID);                                                 // Run CreateNewField Function at end of Class
        },  
                                                                                //Create and Add Qualification Class
        AddQualitifcation = function() {
            var ID = educationField.childElementCount + 1,                      // Id of skill
                                                                                // HTML Content for sector
                html = '<!-- Date --> <label >Start Date:</label> <input type="date"> <label for="enddate">End Date:</label> <input type="date"> <!-- Qualification --> <label>Qualification:</label> <input type="text" > <!-- Institute --> <label >Educational Institute:</label> <input type="text" > <!-- Grade --> <label >Company:</label> <input type="text" >',
                deleteBtn;
            
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
                
                window.console.log(entry);
                educationField.appendChild(entry);
            }
            createNewField(ID);                                                 // Run CreateNewField Function at end of Class
        },
                                                                                //Create and Add Language Class
        AddLanguage = function() {
            var ID = languagesField.childElementCount + 1,                      // Id of skill
                                                                                // HTML Content for sector
                html = ' <label>Language:</label> <input type="text"> <!-- Skill Level --> <label>Type of Liscence:</label> <select> <option value="beginner">Beginner</option> <option value="conversational">Conversational</option> <option value="business">Business</option> <option value="fluent">Fluent</option> <option value="native">Native</option> </select>',
                deleteBtn;
            
            // Create new Entry Field to be appended to section with above HTML
            function createNewField(ID) {
                var entry = document.createElement('DIV');
                entry.className = 'languages';
                entry.innerHTML = html;
                
                var language = "language_l" + ID,
                    skillLevel = "languageSkillLevel_l" + ID,
                
                    languageLabel = entry.getElementsByTagName('label')[0],
                    languageInput = entry.getElementsByTagName('input')[0],
                    skillLevelLabel = entry.getElementsByTagName('label')[1],
                    skillLevelInput = entry.getElementsByTagName('select')[0];
                
                // Set label for and Input name for each field according to ID
                languageLabel.setAttribute("for", language);
                languageInput.setAttribute("name", language);
                skillLevelLabel.setAttribute("for", skillLevel);
                skillLevelInput.setAttribute("name", skillLevel);
                
                window.console.log(entry);
                languagesField.appendChild(entry);
            }
            createNewField(ID);                                                 // Run CreateNewField Function at end of Class
        },
                                                                                // Create and Add Programme Class
        AddProgramme = function() {
            var ID = programmesField.childElementCount + 1,                     // Id of skill
                                                                                // HTML Content for sector
                html = '<label>Computer programme 1:</label> <input type="text"> <!-- Skill Level --> <label>Skill Level:</label> <select> <option value="beginner">Beginner</option> <option value="intermediate">Intermediate</option> <option value="advanced">Advanced</option> </select> ',
                deleteBtn;
            
            // Create new Entry Field to be appended to section with above HTML
            function createNewField(ID) {
                var entry = document.createElement('DIV');
                    entry.className = 'position';
                    entry.innerHTML = html;
                
                var programme = "programme_cp" + ID,
                    skillLevel = "programmeSkillLevel_cp" + ID,
                
                    programmeLabel = entry.getElementsByTagName('label')[0],
                    programmeInput = entry.getElementsByTagName('input')[0],
                    skillLevelLabel = entry.getElementsByTagName('label')[1],
                    skillLevelInput = entry.getElementsByTagName('select')[0];
                
                // Set label for and Input name for each field according to ID
                programmeLabel.setAttribute("for", programme);
                programmeInput.setAttribute("name", programme);
                skillLevelLabel.setAttribute("for", skillLevel);
                skillLevelInput.setAttribute("name", skillLevel);
                
                window.console.log(entry);
                programmesField.appendChild(entry);
            }
            createNewField(ID);                                                 // Run CreateNewField Function at end of Class
        },
    
        CreateCV = function() {
            var cv = {};                                                        // Create CV object
            
            function createNameString(firstnames) {
                var i,
                    namestring = "";
                for (i=0; i < firstnames.length; i++){
                    namestring += firstnames[i].value + " ";
                }
                // Return namestring with extra white space removed
                return namestring.trim();
            }
            
            
            function collectProfessionExp(){
                var i,                                                          // Counting number value for FOR loop
                    professionalExp = [];                                       // Array to hold all Professional Exp Objects
                
                for(i=1; i < professionalExpField.childElementCount+1; i++) {
                    // Create a new object to temporary contain the data for each professional Experience, this is initialised as empty after each loop
                    var newPosition = {};
                    newPosition['startDate']    = document.getElementsByName('startdate_p' + i)[0].value;
                    newPosition['endDate']      = document.getElementsByName('enddate_p' + i)[0].value;
                    newPosition['company']      = document.getElementsByName('company_p' + i)[0].value;
                    newPosition['position']     = document.getElementsByName('position_p' + i)[0].value;
                    // Push new Professional Exp Object to Professional Exp Array
                    professionalExp.push(newPosition);
                }
                
                // Return Array with all Professional Exp Objects inside it
                return professionalExp;
            }
            
            function collectEducation(){
                var i,                                                          // Counting number value for FOR loop
                    education = [];                                       // Array to hold all Education Objects
                
                for(i=1; i < educationField.childElementCount+1; i++) {
                    // Create a new object to temporary contain the data for each professional Experience, this is initialised as empty after each loop
                    var newQualification = {};
                    newQualification['startDate']  = document.getElementsByName('startdate_e' + i)[0].value;
                    newQualification['endDate']    = document.getElementsByName('startdate_e' + i)[0].value;
                    newQualification['qualification']= document.getElementsByName('qualification_e' + i)[0].value;
                    newQualification['institute']  = document.getElementsByName('institute_e' + i)[0].value;
                    newQualification['grade']      = document.getElementsByName('grade_e' + i)[0].value;
                    // Push new Professional Exp Object to Professional Exp Array
                    education.push(newQualification);
                }
                
                // Return Array with all Professional Exp Objects inside it
                return education;
                
            }
            
            function collectLanguages(){
                var i,                                                          // Counting number value for FOR loop
                    languages = [];                                             // Array to hold Language Objects
                
                for(i=1; i < languagesField.childElementCount+1; i++) {
                    // Create a new object to temporary contain the data for each Language, this is initialised as empty after each loop
                    var newLanguage = {};
                    newLanguage['Language']      = document.getElementsByName('language_l' + i)[0].value;
                    newLanguage['skillLevel']    = document.getElementsByName('languageSkillLevel_l' + i)[0].value;
                    
                    // Push new Language Object to Languages Array
                    languages.push(newLanguage);
                }
                
                // Return Array with all Professional Exp Objects inside it
                return languages;
                
            }
            
            function collectComputerSkills(){
                var i,                                                          // Counting number value for FOR loop
                    computerSkills = [];                                       // Array to hold all Computer Skills Objects
                
                for(i=1; i < programmesField.childElementCount+1; i++) {
                    // Create a new object to temporary contain the data for each Computer Skill, this is initialised as empty after each loop
                    var newProgramme = {};
                    newProgramme['programme']      = document.getElementsByName('programme_cp' + i)[0].value;
                    newProgramme['skillLevel']     = document.getElementsByName('programmeSkillLevel_cp' + i)[0].value;

                    // Push new Computer Skills Object to Computer Skills Array
                    computerSkills.push(newProgramme);
                }
                
                // Return Array with all Computer Skills Objects inside it
                return computerSkills;
                
            }
            
            cv['firstname']     = createNameString(firstnames);
            cv['lastname']      = surname.value; 
            cv['nationality']   = nationality.value;
            cv['email']         = email.value;
            cv['tel']           = tel.value;
            cv['address']       = 
                                {
                                    "houseNo":  houseNo.value,
                                    "street":   street.value,
                                    "city":     city.value,
                                    "postcode": postcode.value
                                };
            cv['dob']           = dob.value;
            cv['liscence']      =   
                                {
                                    "type":     liscenceType.value,
                                    "issuer":   liscenceIssuer.value
                                };
            cv['summary']       = "";
            cv['professionExp'] = collectProfessionExp();
            cv['education']     = collectEducation();
            cv['languages']     = collectLanguages();
            cv['programmes']    = collectComputerSkills();
            
            return cv;                                                      // return CV Object
        };

    function sendRequest(type, data) {
        // Request Type (incase multiple)
        formData.set('request', type);
        // CV in this case
        formData.set('data', data);
        // Connection to PHP open
        req.open('POST', php, true);
        //  Send the Request with CV stored in it
        req.send(formData);
    }

     function RequestState(evt) {
        //  wenn Anfrage beendet und Antwort bereit (readystate = 4) und geladen (status = 200) ist
        if (evt.target.readyState === 4 && evt.target.status === 200) {
            window.console.log(this.responseText);
        }
     }

req.addEventListener('readystatechange', RequestState);
// Click Event to add new Professional Exp
    addPosition.addEventListener('click', function(e){
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
    document.getElementById('test').addEventListener('click', function(e){
        e.preventDefault();
        window.console.log("test");
        sendRequest(1, CV)
        //CV = CreateCV();
    });

//});