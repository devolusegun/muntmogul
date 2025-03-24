function animateGraph(time) {
    const path1 = 522.957;
    const path2 = 572.872;

    $("#path1").css({ "stroke-dashoffset": path1 });
    $("#path2").css({ "stroke-dashoffset": path2 });

    setTimeout(() => {
        $("#path1, #path2").show();
    }, 500);

    setTimeout(() => {
        $("#path1").css({ "stroke-dashoffset": 0 });
        $("#path2").css({ "stroke-dashoffset": 0 });

        setTimeout(() => {
            $('.mf-circles').fadeIn(1400);
            $('.funds_label').show();
        }, 1400);
    }, time);

    drawYAxisLabels(); // ✅ Call this
}

function drawYAxisLabels() {
    const direct = parseFloat($("#directFund").text().replace(/[^0-9.]/g, '')) || 0;
    const regular = parseFloat($("#regularFund").text().replace(/[^0-9.]/g, '')) || 0;
    const maxVal = Math.max(direct, regular);

    const svg = document.getElementById("yAxisLabels");
    svg.innerHTML = ""; // Clear previous labels

    const chartHeight = 330;
    const paddingTop = 20;
    const steps = 5;

    for (let i = 0; i <= steps; i++) {
        const value = maxVal * ((steps - i) / steps);
        const y = paddingTop + (chartHeight / steps) * i;

        const text = document.createElementNS("http://www.w3.org/2000/svg", "text");
        text.setAttribute("x", 0);
        text.setAttribute("y", y);
        text.setAttribute("fill", "#ffffff");
        text.setAttribute("font-size", "12");
        text.textContent = formatCurrency(value); // uses your existing formatCurrency()

        svg.appendChild(text);
    }
}

function FV(PMT, IR, NP, yearly) {
    IR = IR / 100;
    if (!yearly) {
        IR = IR / 12;
    }
    const FV = PMT * (Math.pow(1 + IR, NP) - 1) / IR;
    return parseInt(FV);
}

function calculateCompoundInterest(P, years, rate) {
    const ROI = rate / 100;
    const CI = P * Math.pow((1 + ROI), years);
    return parseInt(CI);
}

function changeValueToString(value) {
    value = parseFloat(value);

    if (value >= 1_000_000_000) {
        return `$${(value / 1_000_000_000).toFixed(2)}B`;
    } else if (value >= 1_000_000) {
        return `$${(value / 1_000_000).toFixed(2)}M`;
    } else if (value >= 1_000) {
        return `$${(value / 1_000).toFixed(2)}K`;
    } else {
        return `$${value.toFixed(2)}`;
    }
}


function formatCurrency(value) {
    value = value.toFixed(0);
    if (value >= 1_000_000) {
        return `$${(value / 1_000_000).toFixed(2)}M`;
    } else if (value >= 1_000) {
        return `$${(value / 1_000).toFixed(2)}K`;
    } else {
        return `$${value}`;
    }
}

function validateAndCalculate() {
    const deposit = parseFloat(document.getElementById("investmentAmount").value);
    const sip = parseFloat(document.getElementById("investmentAmountSIP").value);
    const years = parseInt(document.getElementById("investmentYears").value);

    if ((isNaN(deposit) || deposit < 0) && (isNaN(sip) || sip < 0)) {
        alert("Please enter a valid deposit amount or monthly SIP.");
        return;
    }

    if (isNaN(years) || years <= 0) {
        alert("Please select a valid investment duration.");
        return;
    }

    CalCommission(); // safe to run now
}

function CalCommission() {
    $('.mf-circles, .funds_label').hide();
    $("#path1, #path2").hide();

    const path1 = 522.957;
    const path2 = 572.872;
    $("#path1").css({ "stroke-dashoffset": path1 });
    $("#path2").css({ "stroke-dashoffset": path2 });

    // Get user inputs
    const investA = parseFloat($("#investmentAmount").val()) || 0;
    const investSIP = parseFloat($("#investmentAmountSIP").val()) || 0;
    const investY = parseInt($("#investmentYears").val()) || 1;

    $("#years_selected").text(`${investY} Years`);

    const IRDirect = 16; // 16% return
    const IRRegular = 15; // 15% return

    let lumpSumDirect = investA > 0 ? calculateCompoundInterest(investA, investY, IRDirect) : 0;
    let lumpSumRegular = investA > 0 ? calculateCompoundInterest(investA, investY, IRRegular) : 0;

    let months = investY * 12 + 1;
    let sipDirect = investSIP > 0 ? FV(investSIP, IRDirect, months, false) : 0;
    let sipRegular = investSIP > 0 ? FV(investSIP, IRRegular, months, false) : 0;

    const totalDirect = lumpSumDirect + sipDirect;
    const totalRegular = lumpSumRegular + sipRegular;
    const extraReturn = (totalDirect - totalRegular);

    $("#returnAmount").text(changeValueToString(extraReturn));
    $("#directFund").html(changeValueToString(totalDirect));
    $("#regularFund").html(changeValueToString(totalRegular));

    animateGraph(700);
}