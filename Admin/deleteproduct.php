<?php
            $servername="localhost";
            $username="root";
            $password="";
            $dbname="project";

            $conn=new mysqli($servername,$username,$password,$dbname);

            if(isset($_GET['id']))
                {
                    $Id=$_GET['id'];

                    try
                    {
                        if($conn->connect_error)
                            {
                                die("Connection failed:" .$conn->connect_error);
                            }
                            else
                                {
                                $sql="DELETE FROM product where id='".$Id."'";

                                if($conn->query($sql)===TRUE)
                                    {
                                        echo "Record Delete Successfully";
                                    }
                                    else
                                        {
                                            echo "Error: ".$sql. "<br>".$conn->error;
                                        }
                                        $conn->close();

                                        header("Location:viewproduct.php");
                                }
                            }
                            catch(PDOException $e)
                            {
                                echo "An Error Occured:".$e->getMessage();
                            }
                    }
                    else
                        {
                            echo "<h1>Wrong result</h1>";
                        }
                $conn=null;
        ?>