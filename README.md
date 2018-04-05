# PDF CV Builder

A programme to take Data collected from the users input and transformed it into a PDF using PHP, including a photo and clickable links. This gives the user an option to quickly generate a CV, even while on the go and have it emailed to them or another address. This project uses the FPDF php library http://www.fpdf.org/

Futher development would see options saved locally, and perhaps online in a DB with login access to make it easier to change details. I would also like to offer more Designs for users to pick from.

### Done so far:
- [x] HTML form
- [x] JS UI to add input fields for sections
- [x] AJAX Request to POST to PHP
- [x] Photograph saved to folder from input
- [x] PHP rough build of pdf CV from data
- [x] Generated PDF saved

### Still to do:
- [x] CSS - to make the form more presentable, Responsive & user friendly
- [x] JavaScript checks on Imputs to alert user to any incorrect values given
- [x] PHP checks of Data & File before making the PDF
- [ ] Check longer inputs and contraints (JS side done, need to complete PHP checks)
- [x] Change longer names to Initials - all middle names go to initials
- [ ] Make Pdf Prettier
- [ ] Look at TCPDF to see if this will help for layout https://tcpdf.org/

### Further Development
- [ ] Add more designs the user can choose from
- [ ] Saves locally
- [ ] Saves to DB with login 
- [ ] Make select lists more comprehensive
- [ ] Handle alphabet from other Languages
- [ ] Add more fields
