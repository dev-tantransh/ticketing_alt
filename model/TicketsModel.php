<?php

namespace tickets;
require_once "DBConnection.php";
use sql\DBConnection;

class TicketsModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = DBConnection::createConnection();
    }

    public function getTicketPool($req_data){
        $gen_pool = array();
        try {
            $agent_id = $req_data->agent_id;
            $grp_query = "select group_id from groups_users where user_id = ".$agent_id.";";
            $res = mysqli_query($this->conn,$grp_query);
            $groups = "";
            $user_groups = array();
            while ($row = mysqli_fetch_assoc($res)){
                if(strlen($groups) == 0){
                    $groups = $row["group_id"];
                }
                else{
                    $groups = $groups.","+$row["group_id"];
                }
                $user_groups[] = $row["group_id"];
            }

            $gen_pool_query = "select * from ticket_list_views where escalated_group_id in ($groups) and current_agent_id is NULL and ticket_status in (6,5,0,2)";
            $res_gen_pool = mysqli_query($this->conn,$gen_pool_query);

            while($row = mysqli_fetch_assoc($res_gen_pool)){
                $gen_pool[] = $row;
            }

            if(in_array(43,$user_groups) || in_array(44,$user_groups) || in_array(12,$user_groups) || in_array(17,$user_groups) || in_array(46,$user_groups) ){
                $info_tickets_query = "select ticket_id from ticket_activities where status = 5 and agent_id is null and pick_time is null and group_id in ($groups)";
                $res_info_ticket = mysqli_query($this->conn,$info_tickets_query);
                $info_ticket_ids = "";
                while ($row = mysqli_fetch_assoc($res_info_ticket)){
                    if(strlen($info_ticket_ids)==0){
                        $info_ticket_ids = $row["ticket_id"];
                    }
                    else{
                        $info_ticket_ids = $info_ticket_ids.",".$row["ticket_id"];
                    }
                }
                if(strlen($info_ticket_ids) > 0){
                    $info_tickets_query = "select * from ticket_list_views where id in ($info_ticket_ids)";
                    $res_info_tickets = mysqli_query($this->conn, $info_tickets_query);
                    while ($row = mysqli_fetch_assoc($res_info_tickets)){
                        $gen_pool[] = $row;
                    }
                }

            }


            return $gen_pool;
        }
        catch (\Exception $exception){
            return $gen_pool;
        }

    }

}