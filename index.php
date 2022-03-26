<?php require_once "conn.php"; ?>
<!DOCTYPE html>
<html>

<head>
    <title>CARIBBEAN STUD POKER</title>
    <link rel="stylesheet" href="css/reset.css" type="text/css">
    <link rel="stylesheet" href="css/main.css" type="text/css">
    <link rel="stylesheet" href="css/orientation_utils.css" type="text/css">
    <link rel="stylesheet" href="css/ios_fullscreen.css" type="text/css">
    <link rel='shortcut icon' type='image/x-icon' href='./favicon.ico' />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,minimal-ui" />
    <meta name="msapplication-tap-highlight" content="no" />

    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/createjs-2015.11.26.min.js"></script>
    <script type="text/javascript" src="js/howler.min.js"></script>
    <script type="text/javascript" src="js/screenfull.min.js"></script>
    <script type="text/javascript" src="js/platform.js"></script>
    <script type="text/javascript" src="js/ios_fullscreen.js"></script>
    <script type="text/javascript" src="js/ctl_utils.js"></script>
    <script type="text/javascript" src="js/sprite_lib.js"></script>
    <script type="text/javascript" src="js/settings.js"></script>
    <script type="text/javascript" src="js/CLang.js"></script>
    <script type="text/javascript" src="js/CPreloader.js"></script>
    <script type="text/javascript" src="js/CMain.js"></script>
    <script type="text/javascript" src="js/CTextButton.js"></script>
    <script type="text/javascript" src="js/CGfxButton.js"></script>
    <script type="text/javascript" src="js/CToggle.js"></script>
    <script type="text/javascript" src="js/CMenu.js"></script>
    <script type="text/javascript" src="js/CGame.js"></script>
    <script type="text/javascript" src="js/CInterface.js"></script>
    <script type="text/javascript" src="js/CTweenController.js"></script>
    <script type="text/javascript" src="js/CSeat.js"></script>
    <script type="text/javascript" src="js/CFichesController.js"></script>
    <script type="text/javascript" src="js/CVector2.js"></script>
    <script type="text/javascript" src="js/CGameSettings.js"></script>
    <script type="text/javascript" src="js/CEasing.js"></script>
    <script type="text/javascript" src="js/CCard.js"></script>
    <script type="text/javascript" src="js/CGameOver.js"></script>
    <script type="text/javascript" src="js/CMsgBox.js"></script>
    <script type="text/javascript" src="js/CHandEvaluator.js"></script>
    <script type="text/javascript" src="js/CAnimText.js"></script>
    <script type="text/javascript" src="js/CPaytablePanel.js"></script>
    <script type="text/javascript" src="js/CHelpCursor.js"></script>
    <script type="text/javascript" src="js/CCreditsPanel.js"></script>
    <script type="text/javascript" src="js/CCTLText.js"></script>
    <script type="text/javascript" src="js/CFiche.js"></script>
</head>

<body ondragstart="return false;" ondrop="return false;">
    <div style="position: fixed; background-color: transparent; top: 0px; left: 0px; width: 100%; height: 100%"></div>
    <script>
        "use strict"
        let wallet = <?= $user['wallet']; ?>;
        $.ajax({
            url: `getBal.php`,
            type: 'GET',
            cache: false,
            dataType: 'JSON'
        }).done((res) => {
            wallet = res;
        });

        var oMain;
        var dealPrice = 0;

        $(document).ready(function() {
            oMain = new CMain({
                win_occurrence: 40, //WIN OCCURRENCE PERCENTAGE. VALUES BETWEEN 0-100
                min_bet: 0.1, //MIN BET PLAYABLE BY USER. DEFAULT IS 0.1$
                max_bet: 300, //MAX BET PLAYABLE BY USER. 
                money: wallet, //STARING CREDIT FOR THE USER
                game_cash: wallet, //GAME CASH AVAILABLE WHEN GAME STARTS
                fiche_values: [0.1, 1, 5, 10, 25, 100], //FICHE VALUES
                payout: [
                    100, //MULTIPLIER FOR ROYAL FLUSH
                    50, //MULTIPLIER FOR STRAIGHT FLUSH
                    20, //MULTIPLIER FOR FOUR OF A KIND
                    7, //MULTIPLIER FOR FULL HOUSE
                    5, //MULTIPLIER FOR FLUSH
                    4, //MULTIPLIER FOR STRAIGHT
                    3, //MULTIPLIER FOR THREE OF A KIND
                    2, //MULTIPLIER FOR TWO PAIR  
                    1 //MULTIPLIER FOR ONE PAIR OR LESS
                ],
                time_show_hand: 1500, //TIME (IN MILLISECONDS) SHOWING LAST HAND
                show_credits: false, //SET THIS VALUE TO FALSE IF YOU DON'T TO SHOW CREDITS BUTTON
                fullscreen: true, //SET THIS TO FALSE IF YOU DON'T WANT TO SHOW FULLSCREEN BUTTON
                check_orientation: true, //SET TO FALSE IF YOU DON'T WANT TO SHOW ORIENTATION ALERT ON MOBILE DEVICES
                audio_enable_on_startup: false, //ENABLE/DISABLE AUDIO WHEN GAME STARTS 
                //////////////////////////////////////////////////////////////////////////////////////////
                ad_show_counter: 10 //NUMBER OF HANDS PLAYED BEFORE AD SHOWN
                    //
                    //// THIS FUNCTIONALITY IS ACTIVATED ONLY WITH CTL ARCADE PLUGIN.///////////////////////////
                    /////////////////// YOU CAN GET IT AT: /////////////////////////////////////////////////////////
                    // http://codecanyon.net/item/ctl-arcade-wordpress-plugin/13856421 ///////////
            });

            $(oMain).on("recharge", function(evt) {
                iMoney = 1000;
                if (s_oGame !== null) {
                    s_oGame.setMoney(iMoney);
                }
            });

            $(oMain).on("start_session", function(evt) {
                if (getParamValue('ctl-arcade') === "true") {
                    parent.__ctlArcadeStartSession();
                }
                //...ADD YOUR CODE HERE EVENTUALLY
            });

            $(oMain).on("end_session", function(evt) {
                if (getParamValue('ctl-arcade') === "true") {
                    parent.__ctlArcadeEndSession();
                }
                location.reload();
                //...ADD YOUR CODE HERE EVENTUALLY
            });

            $(oMain).on("bet_placed", function(evt, iTotBet) {
                //...ADD YOUR CODE HERE EVENTUALLY
                dealPrice = iTotBet;
            });

            $(oMain).on("save_score", function(evt, iMoney) {
                if (getParamValue('ctl-arcade') === "true") {
                    parent.__ctlArcadeSaveScore({
                        score: iMoney
                    });
                }
                dealPrice = 0;
                    //...ADD YOUR CODE HERE EVENTUALLY
            });

            $(oMain).on("show_interlevel_ad", function(evt) {
                if (getParamValue('ctl-arcade') === "true") {
                    parent.__ctlArcadeShowInterlevelAD();
                }
                //...ADD YOUR CODE HERE EVENTUALLY
            });

            $(oMain).on("share_event", function(evt, iScore) {
                if (getParamValue('ctl-arcade') === "true") {
                    parent.__ctlArcadeShareEvent({
                        img: TEXT_SHARE_IMAGE,
                        title: TEXT_SHARE_TITLE,
                        msg: TEXT_SHARE_MSG1 + iScore + TEXT_SHARE_MSG2,
                        msg_share: TEXT_SHARE_SHARE1 + iScore + TEXT_SHARE_SHARE1
                    });
                }
            });

            if (isIOS()) {
                setTimeout(function() {
                    sizeHandler();
                }, 200);
            } else {
                sizeHandler();
            }
        });

        var gameId;

        function changeBet(iCurBet) {
            dealPrice = iCurBet;
        }

        function deal() {
            gameId = Math.floor(Date.now() / 1000);
            let data = {
                'memberId': <?= $user['id'] ?>,
                'gameId': gameId,
                'money': dealPrice.toFixed(2)
            };

            sendData(data, 'deal');
        }

        function fold(winner, _oSeat) {
            let data;
            data = {
                'gameId': gameId,
                'win': false,
                'money': dealPrice.toFixed(2)
            };
            /* dealPrice = 0; */
            sendData(data, 'fold');
        }

        function raise(winner, _oSeat) {
            let data;
            switch (winner) {
                case 'dealer':
                    data = {
                        'gameId': gameId,
                        'win': false,
                        'money': dealPrice.toFixed(2)
                    };
                    break;
                case 'player':
                    data = {
                        'gameId': gameId,
                        'win': true,
                        'money': (dealPrice + _oSeat.getBetAnte() * 2).toFixed(2)
                    };
                    break;

                default:
                    data = {
                        'gameId': gameId,
                        'win': true,
                        'money': (_oSeat.getBetAnte() * 2).toFixed(2)
                    };
                    break;
            }
            /* dealPrice = 0; */
            sendData(data, 'raise');
        }

        function sendData(data, url) {
            $.ajax({
                url: `${url}.php`,
                type: 'POST',
                dataType: 'JSON',
                data: data,
                success: function() {

                },
            });
        }
    </script>

    <div class="check-fonts">
        <p class="check-font-1">test 1</p>
        <p class="check-font-2">test 2</p>
    </div>

    <canvas id="canvas" class='ani_hack' width="1700" height="768"> </canvas>
    <div data-orientation="landscape" class="orientation-msg-container">
        <p class="orientation-msg-text">Please rotate your device</p>
    </div>
    <div id="block_game" style="position: fixed; background-color: transparent; top: 0px; left: 0px; width: 100%; height: 100%; display:none"></div>
    <input type="hidden" name="money" value="" />
</body>

</html>