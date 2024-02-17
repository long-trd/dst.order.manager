var baseUrl = window.location.origin + '/api/';

function addNotification(notification) {
    let textHtmlNotify = [];
    notification.forEach((item) => {
        textHtmlNotify.push(`<li><div class="thumb"><img src="/assets/img/wheel/icon_gift.svg" alt=""></div><p>${item}</p></li>`);
    });

    document.querySelector(".notification").innerHTML = textHtmlNotify.join("");
}

$(document).ready(function () {
    localStorage.clear();

    const user = userLogin;
    localStorage.setItem("user", JSON.stringify(userLogin));
    get_prizes();
    showNotification();

    async function get_prizes() {
        var prizes = await $.ajax({
            type: "GET",
            url: `${baseUrl}prize`,
            data: "data",
            dataType: "json",
            success: function (response) {
            },
        });

        localStorage.setItem("prizes", JSON.stringify(prizes));
    }

    async function showNotification() {
        $("#timesSpin")[0].innerHTML = user.timesSpin;
        await fetch(`${baseUrl}gift`)
            .then((response) => response.json())
            .then(async (dataNotification) => {
                let notification = [];
                if (!dataNotification) dataNotification = [];
                dataNotification.reverse().forEach((item, i) => {
                    if (item.gift.search(".000") !== -1) {
                        notification.push(`${item.name} đã trúng lì xì trị giá ${item.gift} !!!`);
                    } else {
                        notification.push(`${item.name} đã trúng phần thưởng bất ngờ!!!`);
                    }
                });

                addNotification(notification);
            });
    }
});
