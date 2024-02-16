var baseUrl = window.location.origin + '/api/';

(async function async() {
    var $,
        ele,
        container,
        canvas,
        num,
        prizes,
        btn,
        deg = 0,
        fnGetPrize,
        fnGotBack,
        optsPrize;

    var cssPrefix,
        eventPrefix,
        vendors = {
            "": "",
            Webkit: "webkit",
            Moz: "",
            O: "o",
            ms: "ms",
        },
        testEle = document.createElement("p"),
        cssSupport = {};

    Object.keys(vendors).some(function (vendor) {
        if (testEle.style[vendor + (vendor ? "T" : "t") + "ransitionProperty"] !== undefined) {
            cssPrefix = vendor ? "-" + vendor.toLowerCase() + "-" : "";
            eventPrefix = vendors[vendor];
            return true;
        }
    });

    /**
     * @param  {[type]} name [description]
     * @return {[type]}      [description]
     */
    function normalizeEvent(name) {
        return eventPrefix ? eventPrefix + name : name.toLowerCase();
    }

    /**
     * @param  {[type]} name [description]
     * @return {[type]}      [description]
     */
    function normalizeCss(name) {
        name = name.toLowerCase();
        return cssPrefix ? cssPrefix + name : name;
    }

    cssSupport = {
        cssPrefix: cssPrefix,
        transform: normalizeCss("Transform"),
        transitionEnd: normalizeEvent("TransitionEnd"),
    };

    var transform = cssSupport.transform;
    var transitionEnd = cssSupport.transitionEnd;

    function init(opts) {
        fnGetPrize = opts.getPrize;
        fnGotBack = opts.gotBack;
        opts.config(function (data) {
            prizes = opts.prizes = data;
            num = prizes.length;
            draw(opts);
        });
        events();
    }

    /**
     * @param  {String} id
     * @return {Object} HTML element
     */
    $ = function (id) {
        return document.getElementById(id);
    };

    function draw(opts) {
        opts = opts || {};
        if (!opts.id || num >>> 0 === 0) return;

        var id = opts.id,
            rotateDeg = 360 / num / 2 + 90,
            ctx,
            prizeItems = document.createElement("ul"),
            turnNum = 1 / num,
            html = [];
        htmlCircle = [];

        ele = $(id);
        canvas = ele.querySelector(".hc-luckywheel-canvas");
        container = ele.querySelector(".hc_luckywheel_container");
        between = ele.querySelector(".between");
        btn = ele.querySelector(".hc-luckywheel-btn");

        if (!canvas.getContext) {
            showMsg("Browser is not support");
            return;
        }

        ctx = canvas.getContext("2d");

        for (var i = 0; i < num; i++) {
            ctx.save();
            ctx.beginPath();
            ctx.translate(250, 250); // Center Point
            ctx.moveTo(0, 0);
            ctx.rotate((((360 / num) * i - rotateDeg) * Math.PI) / 180);
            ctx.arc(0, 0, 250, 0, (2 * Math.PI) / num, false); // Radius
            if (i % 2 == 0) {
                ctx.fillStyle = "#FAF9F7";
            } else {
                ctx.fillStyle = "#D6D6D6";
            }
            ctx.fill();
            ctx.lineWidth = 1;
            ctx.strokeStyle = "#00000029";
            ctx.stroke();
            ctx.restore();
            var prizeList = opts.prizes;
            html.push('<li class="hc-luckywheel-item"> <span style="');
            html.push(transform + ": rotate(" + i * turnNum + 'turn)">');

            let turn;
            turn = i * turnNum;
            if (i % 2 == 0) {
                htmlCircle.push(`<div id="circle" class="circle-${i}" style="transform: rotate(${turn}turn)"><div class="circle light"></div></div>`);
            } else {
                htmlCircle.push(`<div id="circle" class="circle-${i}" style="transform: rotate(${turn}turn)"><div class="circle dark"></div></div>`);
            }

            if (opts.mode == "both") {
                if (!prizeList[i].unit) {
                    prizeList[i].unit = "";
                }
                html.push("<p id='curve'>" + prizeList[i].text + "</p>");
                html.push('<div class="unit">' + prizeList[i].unit + "</div>");
                html.push('<img src="' + prizeList[i].img + '" />');
            } else if (prizeList[i].img) {
                html.push('<img src="' + prizeList[i].img + '" />');
            } else {
                html.push('<p id="curve">' + prizeList[i].text + "</p>");
            }
            html.push("</div> </div>");
            if (i + 1 === num) {
                prizeItems.className = "hc-luckywheel-list";
                container.appendChild(prizeItems);
                between.innerHTML = htmlCircle.join("");
                prizeItems.innerHTML = html.join("");
            }
        }
    }

    /**
     * @param  {String} msg [description]
     */
    function showMsg(msg) {
        alert(msg);
    }

    /**
     * @param  {[type]} deg [description]
     * @return {[type]}     [description]
     */
    function runRotate(deg) {
        // runInit();
        // setTimeout(function() {
        container.style[transform] = "rotate(" + deg + "deg)";
        // }, 10);
    }

    /**
     * @return {[type]} [description]
     */
    function events() {
        bind(btn, "click", function () {
            addClass(btn, "disabled");
            let user = JSON.parse(localStorage.getItem("user"));

            if (user.timesSpin === 1) {
                var audio = document.querySelector("#audio_wheel");
                audio.play();
                var audio_main = document.querySelector("#audio_main");
                audio_main.pause();
                fnGetPrize(function (data) {
                    if (data[0] == null && !data[1] == null) {
                        return;
                    }
                    optsPrize = {
                        prizeId: data[0],
                        chances: data[1],
                    };
                    deg = deg || 0;
                    deg = deg + (360 - (deg % 360)) + (360 * 5 - data[0] * (360 / num));
                    runRotate(deg);
                });
                bind(container, transitionEnd, eGot);
            } else {
                alert("Bạn đã hết lượt quay!");
            }
        });
    }

    function eGot() {
        if (optsPrize.chances == null) {
            return fnGotBack(null);
        } else {
            removeClass(btn, "disabled");
            return fnGotBack(prizes[optsPrize.prizeId]?.text);
        }
    }

    /**
     * Bind events to elements
     * @param {Object}    ele    HTML Object
     * @param {Event}     event  Event to detach
     * @param {Function}  fn     Callback function
     */
    function bind(ele, event, fn) {
        if (typeof addEventListener === "function") {
            ele.addEventListener(event, fn, false);
        } else if (ele.attachEvent) {
            ele.attachEvent("on" + event, fn);
        }
    }

    /**
     * hasClass
     * @param {Object} ele   HTML Object
     * @param {String} cls   className
     * @return {Boolean}
     */
    function hasClass(ele, cls) {
        if (!ele || !cls) return false;
        if (ele.classList) {
            return ele.classList.contains(cls);
        } else {
            return ele.className.match(new RegExp("(\\s|^)" + cls + "(\\s|$)"));
        }
    }

    const popUp = document.querySelector(".close");
    popUp.addEventListener("click", function () {
        document.querySelector("#popup").style.display = "none";
    });

    // addClass
    function addClass(ele, cls) {
        if (ele.classList) {
            ele.classList.add(cls);
        } else {
            if (!hasClass(ele, cls)) ele.className += "" + cls;
        }
    }

    // removeClass
    function removeClass(ele, cls) {
        if (ele.classList) {
            ele.classList.remove(cls);
        } else {
            ele.className = ele.className.replace(new RegExp("(^|\\b)" + className.split(" ").join("|") + "(\\b|$)", "gi"), " ");
        }
    }

    let notification = [];

    await fetch(`${baseUrl}gift`)
        .then((response) => response.json())
        .then(async (dataNotification) => {
            if (!dataNotification) dataNotification = [];
            dataNotification.forEach((item) => {
                if (item.gift.search(".000") !== -1) {
                    notification.push(`${item.name} đã trúng lì xì trị giá ${item.gift} !!!`);
                } else {
                    notification.push(`${item.name} đã trúng phần thưởng bất ngờ!!!`);
                }
            });
        });

    function addNotification(notification) {
        let textHtmlNotify = [];
        notification.forEach((item, i) => {
            textHtmlNotify.push(`<li><div class="thumb"><img src="/assets/img/wheel/icon_gift.svg" alt=""></div><p>${item}</p></li>`);
        });

        document.querySelector(".notification").innerHTML = textHtmlNotify.join("");
    }

    var hcLuckywheel = {
        init: function (opts) {
            return init(opts);
        },
    };

    window.hcLuckywheel === undefined && (window.hcLuckywheel = hcLuckywheel);

    if (typeof define == "function" && define.amd) {
        define("HellCat-Luckywheel", [], function () {
            return hcLuckywheel;
        });
    }

    await fetch(`${baseUrl}prize`)
        .then((response) => response.json())
        .then((data) => wheel(data));
    function wheel(prizes) {
        let prizeIndex;
        hcLuckywheel.init({
            id: "luckywheel",
            config: function (callback) {
                callback && callback(prizes);
            },
            mode: "both",
            getPrize: async function (callback) {
                var rand = await randomIndex(prizes);
                var chances = rand;
                prizeIndex = rand;
                callback && callback([rand, chances]);
            },
            gotBack: async function (data) {
                var audio = document.querySelector("#audio_wheel");
                audio.pause();
                var audio_main = document.querySelector("#audio_main");
                audio_main.play();

                if (data == null) {
                    document.getElementById("money").innerHTML = "Hết phần thưởng rồi";
                    document.querySelector(".text_money").innerHTML = "Oops";
                    document.getElementById("popup").style.display = "flex";
                } else {
                    let user = JSON.parse(localStorage.getItem("user"));
                    document.getElementById("popup").style.display = "flex";
                    if (data.search(".000") !== -1) {
                        document.querySelector(".text_money").innerHTML = `Bạn đã trúng phần quà trị giá `;
                        document.getElementById("money").innerHTML = `${data}${prizes[prizeIndex].unit}`;
                        notification.push(`${user.name} vừa trúng lì xì trị giá ${data}${prizes[prizeIndex].unit} !!!`);
                    } else {
                        document.querySelector(".text_money").innerHTML = `Bạn đoán xem phần thưởng của mình nhé :3`;
                        notification.push(`${user.name} vừa trúng phần thưởng bất ngờ!!!`);
                    }

                    user.timesSpin = 0;

                    localStorage.setItem("user", JSON.stringify(user));

                    addNotification(notification.reverse());

                    setTimeout(() => {
                        Promise.all([getGifts({ ...{"user_id": user.id, "prize_id": prizes[prizeIndex].id}, gift: data })]).then((document.querySelector("#timesSpin").innerHTML = user.timesSpin));
                    }, 2000);
                }
            },
        });
    }

    const randomIndex = async (prizes) => {
        let user = JSON.parse(localStorage.getItem("user"));
        let index;

        await fetch(`${baseUrl}prize`)
            .then((response) => response.json())
            .then(async (data) => {
                prizes = data;

                function egcd(a, b) {
                    if (a == 0) return b;

                    while (b != 0) {
                        if (a > b) a = a - b;
                        else b = b - a;
                    }
                    return a;
                }

                let prizeRandom = [];

                prizes.forEach((item) => {
                    if (item.number !== 0) return prizeRandom.push(item);
                });

                let scarcities = prizeRandom.map((item) => item.percentage);

                if (!scarcities.length) return -1;

                let scarcitiesRemoveFirstItem = [];

                scarcities.forEach((item, i) => {
                    if (i > 0) return scarcitiesRemoveFirstItem.push(item);
                });

                let ucln = scarcities[0];

                scarcitiesRemoveFirstItem.forEach((item) => {
                    ucln = egcd(ucln, item);
                });

                prizeRandom.forEach((item, i) => {
                    prizeRandom[i].percentage = item.percentage / ucln;
                });

                let arrayRandom = [];
                prizeRandom.forEach((item) => {
                    for (let i = 0; i < item.percentage; i++) {
                        arrayRandom.push(item);
                    }
                });

                let indexRandom = Math.floor(Math.random() * arrayRandom.length);

                let gift = arrayRandom[indexRandom];

                index = prizes.findIndex((item) => item.id === gift.id);

                if (!prizes[index].number) {
                    await randomIndex(prizes);
                } else {
                    prizes[index].number -= 1;
                    localStorage.setItem("prizes", JSON.stringify(prizes));

                    updatePrizes(prizes[index], prizes[index].id);
                    document.querySelector("#timesSpin").innerHTML = user.timesSpin;
                    return index;
                }
            });

        return index ?? null;
    };
})();
async function getGifts(data) {
    let response = await fetch(`${baseUrl}gift`, {
        method: "GET",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "Content-Type": "application/json",
        }
    });

    let list_gift = await response.json();
    let i = list_gift.length;
    await postGifts(data, data.user_id);
}
async function postGifts(data, i) {
    await fetch(`${baseUrl}gift/${i}`, {
        method: "PUT",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
    });
}
async function updateUse(user) {
    fetch(`${baseUrl}list-staff/${user.id - 1}`, {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(user),
    });
}
async function updateGift(gift) {
    fetch(`${baseUrl}gift`, {
        method: "PUT",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "Content-Type": "application/json",
        },
        body: JSON.stringify(gift),
    });
}

async function updatePrizes(prizes, id) {
    fetch(`${baseUrl}prize/${id}`, {
        method: "PUT",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "Content-Type": "application/json",
        },
        body: JSON.stringify(prizes),
    });
}
