// function retrieved at https://codepen.io/codysechelski/pen/dYVwjb

window.createAlert = function(title, summary, details, severity, dismissible, autoDismiss, appendToId) {
    const iconMap = {
        info: "fa fa-info-circle",
        success: "fa fa-thumbs-up",
        warning: "fa fa-exclamation-triangle",
        danger: "fa fa-exclamation-circle"
    };

    const alertDiv = document.createElement("div");
    alertDiv.classList.add("alert", "w-100", `alert-${severity.toLowerCase()}`);
    
    const icon = document.createElement("i");
    icon.className = iconMap[severity];

    if (title) {
        const msgTitle = document.createElement("h4");
        msgTitle.innerHTML = " " + title;
        msgTitle.prepend(icon);
        alertDiv.appendChild(msgTitle);
    }

    if (summary) {
        const msgSummary = document.createElement("strong");
        msgSummary.innerHTML = summary;
        alertDiv.appendChild(msgSummary);
    }

    if (details) {
        const msgDetails = document.createElement("p");
        msgDetails.innerHTML = details;
        alertDiv.appendChild(msgDetails);
    }

    if (dismissible) {
        const closeButton = document.createElement("span");
        closeButton.className = "close";
        closeButton.innerHTML = "<i class='fa fa-times-circle'></i>";
        closeButton.addEventListener("click", function () {
            alertDiv.classList.add("hide");
            setTimeout(() => alertDiv.remove(), 500);
        });
        alertDiv.appendChild(closeButton);
    }

    const container = document.getElementById(appendToId);
    if (container) {
        container.prepend(alertDiv);
    }

    if (autoDismiss) {
        setTimeout(() => {
            alertDiv.classList.add("hide");
            setTimeout(() => alertDiv.remove(), 500);
        }, 5000);
    }
};
