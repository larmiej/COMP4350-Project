<?php


namespace Facebook\WebDriver;

use Facebook\WebDriver\Exception\ExpectedException;
use Facebook\WebDriver\Exception\UnexpectedAlertOpenException;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

include(__DIR__.'/helper.php');

/********************************************************
*
* DEFINE GLOBALS
*
 *********************************************************/

//start broswer with 5 second timeout
$chrome = 'http://localhost:9515';
$firefox = 'http://localhost:4444/wd/hub';


$host = $chrome; // this is the default
$capabilities = DesiredCapabilities::firefox();
$driver = RemoteWebDriver::create($host, $capabilities, 5000);
$driver->manage()->timeouts()->implicitlyWait(60);
$driver->get('http://ec2-52-32-93-246.us-west-2.compute.amazonaws.com/login');

/********************************************************
 *
 * DEFINE TEST FUNCTIONS
 *
 *********************************************************/

function loginAsDoctor($driver)
{
    login($driver, "john@Doe.com", "password");

    echo "Passed Test - Login As Doctor <br>";
}

function loginAsClient($driver)
{
    login($driver, "jane@Doe.com", "password");

    echo "Passed Test - Login As Client <br>";
}


function testDoctorAppointment($driver)
{
    addAppointment($driver, "Netfix Chilled", 1);
    $driver->wait(60);
    echo "Passed Test - View & Add Doctors Appointment <br>";

}

function testViewClientList($driver)
{
    viewClientList($driver);
    echo "Passed Test  - View Client List <br>";

}

function testViewDetailedClient($driver)
{
    viewClient($driver, '2');
    goHome($driver);
    echo "Passed Test - View Detailed Record of a Client <br>";
}

function testAddDoctorsNote($driver)
{
    addDoctorNotes($driver, "Selenium", "Testing this notes, so we get full marks, because that is important");
    goHome($driver);
    echo "Passed Test  - Add Doctor's Note <br>";
}

function testViewDoctorNotes($driver)
{
    viewDoctorNotes($driver, 5);
    goHome($driver);
    echo "Passed Test - View Doctor's Notes <br>";

}

function testEditClientInfo($driver)
{
    editClientInfo($driver, "Nigeria", "Rivers", "080-419-3892", "Hacker", "Single");
    echo "Passed Test  - Edit Client Record <br>";
}

function testViewSetClientAppointment($driver)
{
    addAppointment($driver, "Headache", 0);
    $driver->wait(60);
    echo "Passed Test - View & Add Client Appointment <br>";
}

/********************************************************
 *
 * RUN USER STORY TESTS
 *
 *********************************************************/

echo "---------------------------------------Iteration2 User Stories---------------------------------- <br>";
echo "1. As a client, I want to be able to set appointments with a doctor on a specific date and time. <br>";
echo "2. As a doctor, I want to be able to view detailed information on a client. Record<br>";
echo "3. As a doctor, I want to be able to view appointments I have in any given day. <br>";
echo "4. As a doctor, I want to be able to write personal notes. <br><br>";
echo "Begin Tests... <br><br>";

//Test1 - Login as Doctor
loginAsDoctor($driver);

//Test 2 - View and Add Doctor Appointment
testDoctorAppointment($driver);

//Test 3 - View Clients List
testViewClientList($driver);

//Test 4 - View detailed record of one client
testViewDetailedClient($driver);

//Test 5 - Add Doctor's Notes
testAddDoctorsNote($driver);

//Test 6 - View some Doctors Notes
testViewDoctorNotes($driver);
logout($driver);

//Test 7 - Login as Client
loginAsClient($driver);

//Test 8 - Edit Client info
testEditClientInfo($driver);

//Test 9 - View and Set Appointment with doctor
testViewSetClientAppointment($driver);
logout($driver);

//close browser
echo "<br>Done Tests <br>";
$driver->quit();
