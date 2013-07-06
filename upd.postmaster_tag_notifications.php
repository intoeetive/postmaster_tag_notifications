<?php


if ( ! defined('BASEPATH'))
{
	exit('Invalid file request');
}

class Postmaster_tag_notifications_upd {

    var $version = 0.2;
    
    function __construct() { 
        // Make a local reference to the ExpressionEngine super object 
        $this->EE =& get_instance(); 
    } 
    
    function install() { 
  

		$this->EE->load->dbforge(); 

        $data = array( 'module_name' => 'Postmaster_tag_notifications' , 'module_version' => $this->version, 'has_cp_backend' => 'n', 'has_publish_fields' => 'n'); 
        $this->EE->db->insert('modules', $data); 

		$fields = array(
			'entry_id'			=> array('type' => 'INT',		'unsigned' => TRUE)
		);

		$this->EE->dbforge->add_field($fields);
		$this->EE->dbforge->add_key('entry_id');
		$this->EE->dbforge->create_table('postmaster_tag_notifications', TRUE);
		
		
		$fields = array(
			'entry_id'			=> array('type' => 'INT',		'unsigned' => TRUE)
		);

		$this->EE->dbforge->add_field($fields);
		$this->EE->dbforge->add_key('entry_id');
		$this->EE->dbforge->create_table('postmaster_sites_notifications', TRUE);
		
      	$q = $this->EE->db->select('entry_id')->from('channel_titles')->where('status', 'open')->get();
      	foreach ($q->result_array() as $row)
      	{
      		$ins = array('entry_id' => $row['entry_id']);
      		$this->EE->db->insert('postmaster_tag_notifications', $ins);
      		$this->EE->db->insert('postmaster_sites_notifications', $ins);
      	}
        
        return TRUE; 
        
    } 
    
    
    function uninstall() { 

        $this->EE->load->dbforge(); 
		
		$this->EE->db->select('module_id'); 
        $query = $this->EE->db->get_where('modules', array('module_name' => 'Postmaster_tag_notifications')); 
        
        $this->EE->db->where('module_id', $query->row('module_id')); 
        $this->EE->db->delete('module_member_groups'); 
        
        $this->EE->db->where('module_name', 'Postmaster_tag_notifications'); 
        $this->EE->db->delete('modules'); 
        
        $this->EE->db->where('class', 'Postmaster_tag_notifications'); 
        $this->EE->db->delete('actions'); 
        
        //$this->EE->dbforge->drop_table('postmaster_tag_notifications');

        return TRUE; 
    } 
    
    function update($current='') 
	{ 
   		$this->EE->load->dbforge(); 
		   
		if ($current < 0.2)
   		{
   			$fields = array(
				'entry_id'			=> array('type' => 'INT',		'unsigned' => TRUE)
			);
	
			$this->EE->dbforge->add_field($fields);
			$this->EE->dbforge->add_key('entry_id');
			$this->EE->dbforge->create_table('postmaster_sites_notifications', TRUE);
			
	      	$q = $this->EE->db->select('entry_id')->from('channel_titles')->where('status', 'open')->get();
	      	foreach ($q->result_array() as $row)
	      	{
	      		$ins = array('entry_id' => $row['entry_id']);
	      		$this->EE->db->insert('postmaster_sites_notifications', $ins);
	      	}
   		}
		return TRUE; 
    } 
	

}
/* END */
?>