document.addEventListener("DOMContentLoaded", () => {
    setInterval(() => {
        decreaseSecond();
    }, 1000);

    // Add event to prevent user press F5;
    disableF5Event();
    document.querySelector("form").addEventListener(
        "submit",
        () => {
            document.querySelector("#staticLoading").style.display = "block";
        },
        false
    );
});

const decreaseSecond = () => {
    let currentValue = document.querySelector("[name=time-left]").value;
    document.querySelector(["[name=time-left]"]).value = currentValue - 1;

    let currentSec = document.querySelector([".time_second"]).innerHTML;
    if (currentSec > 0) {
        document.querySelector([".time_second"]).innerHTML = currentSec - 1;
    } else {
        document.querySelector([".time_second"]).innerHTML = 59;
        decreaseMinute();
    }
};

const decreaseMinute = () => {
    let currentSec = document.querySelector([".time_minute"]).innerHTML;
    if (currentSec > 0) {
        document.querySelector([".time_minute"]).innerHTML = currentSec - 1;
    } else {
        endExam();
    }
};

const endExam = () => {
    document.querySelector("form button[value=submit]").click();
};

// Disabled F5 event:

const disableF5Event = () => {
    window.history.forward(1);
    document.addEventListener("keydown", preventF5);
    function preventF5(event) {
        console.log(event);
        switch (event.keyCode) {
            case 116: // 'F5'
                event.returnValue = false;
                event.keyCode = 0;
                window.status = "We have disabled F5";
                break;
        }
    }
};
