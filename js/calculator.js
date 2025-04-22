$(document).ready(function () {

    $(".calc_btn").on("click", function () {
        validateAndCalculate();
    });

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

        drawYAxisLabels();
    }

    function drawYAxisLabels() {
        const totalReturn = parseFloat($("#directFund").text().replace(/[^0-9.]/g, '')) || 0;
        const initialInvest = parseFloat($("#regularFund").text().replace(/[^0-9.]/g, '')) || 0;
        const maxVal = Math.max(totalReturn, initialInvest);

        const svg = document.getElementById("yAxisLabels");
        svg.innerHTML = "";

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
            text.textContent = formatCurrency(value);

            svg.appendChild(text);
        }
    }

    function calculateCompoundReturn(principal, months, monthlyRatePercent) {
        const rate = monthlyRatePercent / 100;
        const finalValue = principal * Math.pow(1 + rate, months);
        return parseInt(finalValue);
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
        const depositEl = document.getElementById("investmentAmount");
        const monthsEl = document.getElementById("investmentYears");
        const planEl = document.getElementById("planSelector");

        if (!depositEl || !monthsEl || !planEl) {
            alert("Something is missing in the form. Please reload the page.");
            return;
        }

        const deposit = parseFloat(depositEl.value);
        const months = parseInt(monthsEl.value);
        const plan = planEl.value;

        if (isNaN(deposit) || deposit <= 0) {
            alert("Please enter a valid deposit amount.");
            return;
        }

        if (isNaN(months) || months <= 0) {
            alert("Please select a valid investment duration.");
            return;
        }

        if (!plan) {
            alert("Please select a plan.");
            return;
        }

        CalCommission(deposit, months, plan);
    }

    function CalCommission(deposit, months, plan) {
        $('.mf-circles, .funds_label').hide();
        $("#path1, #path2").hide();

        const planRates = {
            gold: 52,
            copper: 37,
            bronze: 28,
            silver: 20
        };

        const monthlyRate = planRates[plan.toLowerCase()];
        const finalAmount = calculateCompoundReturn(deposit, months, monthlyRate);
        const profit = finalAmount - deposit;

        $("#years_selected").text(`${months} Month${months > 1 ? 's' : ''}`);
        $("#returnAmount").text(changeValueToString(profit));
        $("#directFund").html(changeValueToString(finalAmount));
        $("#regularFund").html(changeValueToString(deposit));

        animateGraph(700);
    }

});
