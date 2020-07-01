<?php
    class Acl {
        private $db;
        private $user_empty = false;

        public function __construct() {
            $this->db = new Database;
        }

        public function count_group_permissions($permission,$group_id) {

            $this->db->query('
            SELECT 
            COUNT(*) AS count

            from usergroups U,
            users_permissions UP,
            usergroups_permissions GP

            where GP.permission_id = UP.permission_id
            and GP.group_id = U.group_id
            AND UP.permission_name = :permission
            AND U.group_id = :group_id
            ');
            
            $this->db->bind(':permission', $permission);
            $this->db->bind(':group_id', $group_id);
            $row = $this->db->single();

             if($row->count>0) {
              return true;
                } else {
                  return false; 
              }
        }

        public function group_permissions($permission,$group_id) {

            $this->db->query('
            SELECT 
            U.group_id,
            UP.permission_id,
            UP.permission_name
            from usergroups U,
            users_permissions UP,
            usergroups_permissions GP
            where GP.permission_id = UP.permission_id
            and GP.group_id = U.group_id
            AND UP.permission_name = :permission
            AND U.group_id = :group_id
            ');
            
            // Bind value
            $this->db->bind(':permission', $permission);
            $this->db->bind(':group_id', $group_id);
            $row = $this->db->single();
            return $row;

        }

        public function getUserGroups() {
            $this->db->query('
            SELECT 
            group_id,
            group_name      
            FROM usergroups
            ');
            return $this->db->resultSet();
        }

        public function getUserGroupsPartner() {
            $this->db->query('
            SELECT 
            group_id,
            group_name      
            FROM usergroups
            WHERE group_id = 5 OR group_id = 6 OR group_id = 7 OR group_id = 8
            ');
            return $this->db->resultSet();
        }

        public function showUsersPermissions($group_id) {

            $this->db->query('
            SELECT 
            U.group_id,
            UP.permission_id,
            UP.permission_name
            from usergroups U,
            users_permissions UP,
            usergroups_permissions GP
            where GP.permission_id = UP.permission_id
            and GP.group_id = U.group_id
            AND U.group_id = :group_id
            ');
            
            // Bind value
            $this->db->bind(':group_id', $group_id);
            return $this->db->resultSet();
        }

    }