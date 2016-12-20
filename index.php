<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="index.css" />      
    </head>
    <body>
        <br>

        <div id="header">
            <span><f1><img src="./logo/logo_full" width="350" height="60"></f1></span>
        </div>

        <table id="member" class="member-table">
        <?php
            include 'member_box.php';

            update($members, $model);

            getAllMembersTable($members, 4);
        ?>                          
        </table>
        
        <br><br>        
        <div id="footer">
            <form method="post" action="member/manager.php">
                <input type="submit" value="メンバー管理画面"> 
            </form>
        </div>
        
    </body>
</html>
