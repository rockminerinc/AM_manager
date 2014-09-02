<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 */
	
    function __construct() 
	{
        parent::__construct();
		$this->load->helper('functions');
  		$this->load->library('form_validation');
		$this->load->helper('url');
  		$this->load->library('pager');
		
  		$this->load->database();
  		date_default_timezone_set("Etc/GMT-8");
		
		$this->clear();
	}

 
	
	public function groups()
	{
		$this->data['page_url']	= 'index.php?c='.$this->router->class.'&m='.$this->router->method.'&page';//?page=2
		$this->data['page_size']= 30;
 		$this->data['page_num'] = isset($_GET['page'])?$_GET['page']:1; //页码
		$page = !$this->pager->is_Page($this->data['page_num']) ? 1 : $this->data['page_num'];
 
		$sql_sum="SELECT  COUNT(gid) as groups_num where 1 ";
 		//$this->data['rows_num'] = $this->db->query($sql)->row()->groups_num;
 
		
 		$limits =  " LIMIT ".$this->data['page_size']*($page-1).','.$this->data['page_size'];
		
		$this->pager->init($this->data);		
		$this->data['page_links']=$this->pager->create_links();	 
		$sql="SELECT * FROM groups  WHERE 1 ".$limits;
		//var_dump($sql);
		$this->data['datas'] = $this->db->query($sql)->result();
		//var_dump($this->data['datas'] );
		$this->data['title']= 'summary';
 
		$this->load->view('common/header', $this->data);	
		$this->load->view('common/left');	
		$this->load->view('groups');	
		
		$this->load->view('common/footer');			
	
	}
	
	public function commands()
	{
		$this->data['page_url']	= 'index.php?c='.$this->router->class.'&m='.$this->router->method.'&page';//?page=2
		$this->data['page_size']= 30;
 		$this->data['page_num'] = isset($_GET['page'])?$_GET['page']:1; //页码
		$page = !$this->pager->is_Page($this->data['page_num']) ? 1 : $this->data['page_num'];
 
		$sql_sum="SELECT  COUNT(cid) as command_num where 1 ";
 		$this->data['rows_num'] = $this->data['hash_sum']->command_num;
 
		
 		$limits =  " LIMIT ".$this->data['page_size']*($page-1).','.$this->data['page_size'];
		
		$this->pager->init($this->data);		
		$this->data['page_links']=$this->pager->create_links();	 
		$sql="SELECT * FROM commands  WHERE 1 ".$limits;
		//var_dump($sql);
		$this->data['datas'] = $this->db->query($sql)->result();
		$this->data['title']= 'summary';
 
		$this->load->view('common/header', $this->data);	
		//$this->load->view('common/left');	
		$this->load->view('commands');	
		
		$this->load->view('common/footer');			
	
	}
	
	public function index()
	{
		
 		
 
 		$this->form_validation->set_rules('del_id[]', 'del_id', 'xss_clean');
	
		if($this->form_validation->run())
		{
			$del_id = $this->input->post('del_id');
			if($del_id!='')
			{
 
				$del_num=count($del_id); 
				//var_dump($del_id);
				for($i=0;$i<$del_num;$i++){ 
				$this->db->query("Delete from t1miners where tid='$del_id[$i]'  "); 
				}
				
				showmsg('delete OK',WEB_ROOT,'3');
				 
			}
			else
			{ 
				showmsg('please check first OK',WEB_ROOT,'3');
			}
			
		}
	  
	
		$orderby = $this->input->get('orderby');

		$sort = $this->input->get('sort');
				if($sort=="")
			$sort='DESC';
			
		//echo '3';
		
		$this->data['page_url']	= 'index.php?c='.$this->router->class.'&m='.$this->router->method.'&orderby='.$orderby.'&sort='.$sort.'&page';//?page=2
		$this->data['page_size']= 50;
		//$this->data['rows_num'] = $this->db->count_all_results('miners');
		$this->data['page_num'] = isset($_GET['page'])?$_GET['page']:1; //页码
		$page = !$this->pager->is_Page($this->data['page_num']) ? 1 : $this->data['page_num'];
 
		$sql_sum="SELECT  COUNT(tid) as ip_num,SUM(hash) as hashavg, SUM(dev_num) as blades FROM t1miners where 1 ";
		$this->data['hash_sum'] = $this->db->query($sql_sum)->row();
		//var_dump($this->data['hash_sums']);
		$this->data['rows_num'] = $this->data['hash_sum']->ip_num;
	 	//echo '4';
	 	switch ($orderby) {
	 		case 'ip':
	 			$condition = ' order by ipint ';
	 			break;
 
	 		case 'hash':
	 			$condition = ' order by hash ';
	 			break;
	 		case 'time':
	 			$condition = ' order by event_time ';
	 			break;
  
	 		case 'devnum':
	 			$condition = ' order by dev_num ';
				break;
 	 		case 'hws':
	 			$condition = ' order by hws ';
				break;
	 		case 'efi':
	 			$condition = ' order by efi ';
				break;
	 		default:
	 			$condition = ' order by tid ';
	 			break;
	 	}
		$condition .= $sort; 
 		//echo '5';
 		$limits =  " LIMIT ".$this->data['page_size']*($page-1).','.$this->data['page_size'];
		
		$this->pager->init($this->data);		
		$this->data['page_links']=$this->pager->create_links();	 
		$sql="SELECT tid,ip_address,ipint,hash,dev_num,event_time,server,efi,hws FROM t1miners  WHERE 1  ".$condition." ".$limits;
		//var_dump($sql);
		$this->data['datas'] = $this->db->query($sql)->result();
		$this->data['title']= 'summary';
		if($sort=="DESC")
		$this->data['sort']= 'ASC';
		else
		$this->data['sort']= 'DESC';
		$this->load->view('common/header', $this->data);	
		$this->load->view('common/left');	
		$this->load->view('tone');
		
		$this->load->view('common/footer');		
		
		 
	}	
	
	public function cron()
	{
		//$this->grapData();

		$sql = "SELECT tid FROM t1miners where efi > 85 limit 10";
		$result = $this->db->query($sql)->result_array();
		if($result)
		foreach($result as $key => $value)
		{
	 
			$this->AddReboot($value['tid']);
		}
		
		echo 'ok';
	}


	public function grapData()
	{
		//结合cron定时抓取数据
		$sql="select rack,start,end from groups where 1";

		$result = $this->db->query($sql)->result();
		foreach ($result as $key => $value) 
		{
			$rack = $value->rack;

			$start=$value->start;
			$end=$value->end;			
	 		$count = $end - $start+1;


	 		$iplist=array();
	 		$hashdatas = array();
	 		$monitor_url = WEB_ROOT;
 
	 		 
			while ($count>0 ) 
			{
				$ip = '192.168.'.$rack.'.'.$count;
				$url	=	'http://192.168.'.$rack.'.'.$count.':8000';
				//var_dump($url);
				$hashdatas[$ip] 	=$this->getMinerData($url);
				if($hashdatas[$ip]['hash'] != '<font color=red><b>timeout</b></font>')
				{
					//保存IP到云端
					$t1_data['ip'] = $ip;
					$t1_data['server'] = $this->getip();
					$t1_data['num'] = $hashdatas[$ip]['num'];
					$t1_data['hash'] = $hashdatas[$ip]['hash'];
					$t1_data['hws'] = $hashdatas[$ip]['hws'];
					$t1_data['efi'] = $hashdatas[$ip]['efi'];
					//if($save)
					 echo $ip;
					$this->insertData($t1_data);
					 
				}
					//$iplist[] = $ip ;
				$count--;
			}
			//$command = 'sudo python /usr/share/nginx/www/shell/tone.py -r '.$value->rack.' -s '.$value->start.'  -e '.$value->end.' > /dev/null &';
			//echo $command;
			//exec( $command , $output ,$result);
			//exec('sudo chmod 777 /usr/share/nginx/www/data/tone-rack'.$rack.'.txt');
			//var_dump($output);
			//exec( > /dev/null &');

			# code...
			//$this->importData($value->rack);
		}

	}


	function post_to_monitor($monitor_url,$t1_data)
	{


		$miner_json = json_encode($t1_data);
  		
		$url=$monitor_url."/index.php?c=home&m=gett1data&data=".$miner_json;
  		
		$re=$this->geturl($url);//($url);
		//var_dump($re);
		if($re)
		{

			$commands_array = json_decode($re);

			foreach ($commands_array as $key => $value) 
			{
				$ip = long2ip($value->ipint);
	 			switch ($value->command) {
					case 'reboot':
						$this->reboot_cmd_proc($ip);
						$this->close_command($value->cid);
						break;

					case 'setting':
						$data = (array) json_decode($value->para);
						//var_dump($data);
						$re=$this->pool_cmd_proc($ip,$data);
						//var_dump($value);
						$this->close_command($value->cid);
						//var_dump($cid);
						//var_dump($re);
						break;

					default:
						echo '';
						//$this->reboot_cmd_proc($ip);
						break;
				}
	 
				//$value->ipint;

			}

		}


		//return;
		//var_dump($commands_array);

		//echo $re;
	}

function object_array($array) {  
    if(is_object($array)) {  
        $array = (array)$array;  
     } if(is_array($array)) {  
         foreach($array as $key=>$value) {  
             $array[$key] = object_array($value);  
             }  
     }  
     return $array;  
}  


	function getMinerData($url)
	{
 

		$url_statistics = $url.'/Statistics/';
		//$htmDoc=@file_get_contents($url_statistics, 0, $ctx);//($url);
		$htmDoc=@$this->geturl($url_statistics);//($url);
 
 		//var_dump($htmDoc);
 		if($htmDoc)
 		{

     		$reg='/<font face="courier new" size=2 color=white><br>(.*?)<br><br><input type="button" value="ReSession"/';
			preg_match($reg, $htmDoc, $arr);
			$boards = explode('Board ', $arr[1]);
		    $data['num'] = count($boards)-1;

 			$reg2= '/<font face="courier new" size=2 color=black><h3>(.*?)<\/h3>/';
			preg_match($reg2, $htmDoc, $arr2);
 	    	$temp = $arr2[1];
	    	$data['hash']= @$this->getSubstr($arr2[1],'Real performance:','GHs');
	    	$data['efi']= @$this->getSubstr($temp,'Miner:','%, Network diff');
	    	$data['hws']= @$this->getSubstr($temp,'Hardware errors:','%, PwrDn');

	    	//var_dump($data);
	    	 
    	}
    	else
    	{
    		$data['num']=0;
    		$data['hash']='<font color=red><b>timeout</b></font>';
    		
    	}

 
    	return $data;



	}



	function getSubstr($str, $leftStr, $rightStr)
	{
	    $left = strpos($str, $leftStr);
	    //echo '左边:'.$left;
	    $right = strpos($str, $rightStr,$left);
	    //echo '<br>右边:'.$right;
	    if($left < 0 or $right < $left) return '';
	    return substr($str, $left + strlen($leftStr), $right-$left-strlen($leftStr));
	}


	public function reboot()
	{

		$this->form_validation->set_rules('reboot', 'reboot', 'trim|required|xss_clean');	

		if($this->form_validation->run())
		{

			//$exec('sudo reboot');
			$filename = "/usr/share/nginx/www/data/timezone.txt";
			 $ctx = stream_context_create(array( 
					        'http' => array( 
					            'timeout' => 1    //设置超时
					            ) 
					        ) 
					    ); 

			$timezone= file_get_contents($filename, 0, $ctx); 
			$timezone_url = '/usr/share/zoneinfo/Etc/'.$timezone;
			//cp /usr/share/zoneinfo/Asia/Shanghai /etc/localtime
			exec('sudo cp '.$timezone_url.' /etc/localtime');

			
			$command = 'sudo reboot 2>&1';

			exec( $command , $output ,$result);

			//var_dump($command);
			//var_dump($output);
			//var_dump($result);
			showmsg('Rebooting...Wait for 45s...',WEB_ROOT,'45');	


		}
		else
		{
		$this->data['title']= 'reboot';
		$this->load->view('common/header', $this->data);	
		$this->load->view('common/left');	
		$this->load->view('reboot');	
		$this->load->view('common/footer');			

		}

		
		
	}

 	function rebootTone()
	{
		$ip=$this->input->get('ip');
		$data['update']='Update/Restart';
		$result = $this->post('http://'.$ip.':8000/Settings/Upload_Data', $data);
		echo $ip.$result;
	}	
	

 
	function post($url, $post_data)
	{	

		//$post_data = @implode('&',$data); 
		//$post_data = $data;
		$ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	    @curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: '.strlen($post_data)));
	    $result = curl_exec($ch);
	    curl_close($ch);

	    return $result;
	}	


 
	

	public function deltone()
	{
		$tid= $this->input->get('tid');
		if(empty($tid))
		{
			echo 'tid error';
		}
		else
		{
			$query=$this->db->get_where('t1miners', array('tid' => $tid));
			if($query->num_rows()>0)
			{
				$this->db->delete('t1miners', array('tid' => $tid)); 
				showmsg('delete OK',WEB_ROOT,2);
			}
			else
				showmsg('tid donot exist',WEB_ROOT,2);//echo 'mid donot exist';
		}

	}
	
	public function clear()
	{
		//asc_mhs_av	asc_mhs_5s	asc_mhs_5m
		$now_ago=time()-600;
		//var_dump($now_ago);
		//$time_ago=
		//$sql="select mid FROM miners WHERE  asc_last_share_time <  $now_ago limit 10";
		$sql="DELETE FROM miners WHERE asc_last_share_time < $now_ago  limit 10 ";
		
		$this->data['datas'] = $this->db->query($sql);
		//var_dump($this->data['datas']);
		
		$sql2="DELETE FROM miners WHERE asc_mhs_av=0 AND asc_mhs_5s=0  and groups=0 limit 10";
		$this->db->query($sql2);
		//echo 'ok';
 	}


 	public function scanRack()
	{


 		$count = $end - $start+1;
 		if ($rack) {
 			$scan=1;
 		}
 		else
 			$scan=0;

 		$iplist=array();
 		$hashdatas = array();
 		$monitor_url = 'http://rockmonitor.sinaapp.com/';
		while ($count>0&&$scan ) {

			//$line=	fgets($handle);
			//$line=str_replace("\n","",$line);
			$ip = '192.168.'.$rack.'.'.$count;
			$url	=	'http://192.168.'.$rack.'.'.$count.':8000';
			$hashdatas[$ip] 	=$this->getMinerData($url);
			if($hashdatas[$ip]['hash'] != '<font color=red><b>timeout</b></font>')
			{
				//保存IP到云端
				$t1_data['ip'] = $ip;
				echo $ip;
				$t1_data['server'] = $this->getip();
				$t1_data['num'] = $hashdatas[$ip]['num'];
				$t1_data['hash'] = $hashdatas[$ip]['hash'];
				$t1_data['hws'] = $hashdatas[$ip]['hws'];
				$t1_data['efi'] = $hashdatas[$ip]['efi'];
				//if($save)
				$this->insertData($t1_data);
			}
				//$iplist[] = $ip ;
			$count--;
		}
 

	}

 
 	public function importData($filename)
	{
		//$re = file_get_contents('/usr/share/nginx/www/data/tone-rack50.txt');
		//$filename = '/usr/share/nginx/www/data/tone-rack'.$rack;
    	$handle = fopen($filename, 'r');
    	while(!feof($handle)){
    		$line =json_decode(fgets($handle));
    		//var_dump($line);
    		foreach ($line as $key => $value)
    		{
    			//var_dump($data);
    			$data= explode(':',$value);
    			switch ($data[0]) {
    				case 'ip':
    					# code...
 	    				$ip=$data[1];
	    				$ipint = bindec( decbin( ip2long( $ip) ) );  				
    					break;
    				case 'Realperformance':
    					$hash=$data[1];
    					$hash=str_replace('GHs','',$hash);
    					break;

    				case 'Miner':
    					$efi=$data[1];
    					break;

    				case 'Hardwareerrors':
    					$hws=$data[1];
    					break;
    				case 'boards':
    					$dev_num=$data[1];
    					break;

    				default:
    					# code...
    					break;
    			}
    			//var_dump($dd);
    			# code...
    		}

    		$server = $this->getip();
    		$event_time = time();
  
	    		if(!empty($ipint)&&!empty($hash)&&!empty($efi)&&!empty($hws)&&!empty($dev_num))
	    		{
					$sql="select tid from t1miners where ipint = ".$ipint." limit 1";

					$result = $this->db->query($sql);
			 
					if($result->num_rows()>0)
					{
					 
						//老机器
						$data = array(
			 						  'dev_num' 		=> $dev_num ,
									  'hash' 			=> $hash ,
									  'server' 			=> $server ,
									  'efi' 			=> $efi ,
									  'hws' 			=> $hws ,

									  'event_time' 			=> $event_time,
		 
									  );
						$this->db->where('tid', $result->row()->tid);
						//if($this->db->insert('makers', $data))
						$this->db->update('t1miners', $data);
						//echo $time;
						//echo $this->get_commands();
						echo 'update OK.';

					}
				
					else
					{
						
						//新机器
						$data2 = array(
									  'ip_address' 			=> $ip ,
		 							  'ipint' 				=> $ipint ,
		 							  'dev_num' 			=> $dev_num ,
									  'hash' 			=> $hash,
									  'server' 			=> $server,
									  'event_time' 			=> $event_time,
		 							  'efi' 			=> $efi ,
									  'hws' 			=> $hws ,
		 							  );

						$this->db->insert('t1miners', $data2);
						echo 'add OK.';
						//echo $this->get_commands();
					}

				}

    		//echo '<br>';
    		//break;
    		//var_dump(json_decode($line));
    	}
    	fclose($handle);
    	exec('sudo rm -rf '.$filename);	
		//var_dump($re);
	}


	public function insertData($data)
	{
  
    		$data['server'] = $this->getip();
    		$data['time']   = time();
    		$data['ipint']  = bindec( decbin( ip2long( $data['ip']) ) ); 

	    		if(!empty($data['ipint']))
	    		{
					$sql="select tid from t1miners where ipint = ".$data['ipint']." limit 1";

					$result = $this->db->query($sql);
			 
					if($result->num_rows()>0)
					{
					 
						//老机器
						$data = array(
			 						  'dev_num' 		=> $data['num'] ,
									  'hash' 			=> $data['hash'] ,
									  'server' 			=> $data['server'] ,
									  'efi' 			=> $data['efi'] ,
									  'hws' 			=> $data['hws'] ,
									  'event_time' 		=> $data['time'],
		 
									  );
						$this->db->where('tid', $result->row()->tid);
						//if($this->db->insert('makers', $data))
						$this->db->update('t1miners', $data);
						//echo $time;
						//echo $this->get_commands();
						echo 'update OK.';

					}
				
					else
					{
						
						//新机器
						$data2 = array(
									  'ip_address' 			=> $data['ip']  ,
		 							  'ipint' 				=>  $data['ipint'] ,
			 						  'dev_num' 		=> $data['num'] ,
									  'hash' 			=> $data['hash'] ,
									  'server' 			=> $data['server'] ,
									  'efi' 			=> $data['efi'] ,
									  'hws' 			=> $data['hws'] ,
									  'event_time' 			=> $data['time'],
		 							  );

						$this->db->insert('t1miners', $data2);
						echo 'add OK.';
						//echo $this->get_commands();
					}

				}

    	 
 
	}


	public function setip()
	{
		$this->data['title']= 'setip';

		$this->form_validation->set_rules('JMIP', 'JMIP', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('JMSK', 'JMSK', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('JGTW', 'JGTW', 'trim|required|xss_clean');	


		if($this->form_validation->run())
		{
			$content ="auto lo
auto eth0
allow-hotplug eth0
iface lo inet loopback
iface eth0 inet static\n";

			$JMIP=$this->input->post('JMIP', TRUE);
			$JMSK=$this->input->post('JMSK', TRUE);
			$JGTW=$this->input->post('JGTW', TRUE);

			$content .= 'address '.$JMIP."\n";
			$content .= 'netmask '.$JMSK."\n";
			$content .= 'gateway '.$JGTW."\n";


			$file_pointer = @fopen('/etc/network/interfaces','w'); 
			if($file_pointer === false)
			{

				showmsg('/etc/network/interfaces open error');
				exec('sudo chmod 777 /etc/network/interfaces');
			}   
			else
			{
				fwrite($file_pointer,$content);
				fclose($file_pointer);
				exec('sudo /etc/init.d/networking restart');
				showmsg('IP update OK!');
			}    

		}
		else
		{
			$lines = file('/etc/network/interfaces');
			foreach ($lines as $line_num => $line) 
			{
				$address = strstr($line, 'address');
				if($address)
				{
					$address_arr = explode(" ",$address);
					$this->data['ip_adress']=$address_arr['1'];
				}
				
				//mask
				$Mask = strstr($line, 'netmask');
				if($Mask)
				{
					$Mask_arr = explode(" ",$Mask);
					$this->data['mask']=$Mask_arr['1'];
				}
				//gateway
				$gateway = strstr($line, 'gateway');
				if($gateway)
				{
				$gateway_arr = explode(" ",$gateway);
				$this->data['gateway_id']=$gateway_arr['1'];
				//echo $gateway_id;
				}
				
			}

			$this->load->view('common/header', $this->data);	
			$this->load->view('common/left');	
			$this->load->view('setip');	
			
			$this->load->view('common/footer');	

		}

		
	}
	
	public function setdns()
	{
		$this->data['title']= 'setdns';
		$this->form_validation->set_rules('PDNS', 'PDNS', 'trim|xss_clean');	
		$this->form_validation->set_rules('SDNS', 'SDNS', 'trim|xss_clean');	
		if($this->form_validation->run())
		{
			//showmsg('1');
			$PDNS=$this->input->post('PDNS', TRUE);
			$SDNS=$this->input->post('SDNS', TRUE);
			$content = 'nameserver '.$PDNS."\n";
			$content .= 'nameserver '.$SDNS."";

			$file_pointer = fopen('/etc/resolv.conf','w'); 
			if($file_pointer === false)
			{
				showmsg('/etc/resolv.conf open error');
				exec('sudo chmod 777 /etc/resolv.conf');
			}
			else
			{
				fwrite($file_pointer,$content);
				fclose($file_pointer);
				exec('sudo /etc/init.d/networking restart');
				showmsg('DNS updated OK!');
			}

		}
		else
		{
				$lines = file('/etc/resolv.conf');
				foreach ($lines as $line_num => $line) 
				{
					$nameserver = strstr($line, 'nameserver');
					if($nameserver)
					{
						$address_arr = explode(" ",$nameserver);
						$this->data['nameservers'][]=$address_arr['1'];
					}

				}
				$this->load->view('common/header', $this->data);	
				$this->load->view('common/left');	
				$this->load->view('setdns');	
				$this->load->view('common/footer');	

		}

	}

	function getip()
	{
			@exec("ifconfig -a", $return_array);

			$temp_array = array();
			foreach ( $return_array as $value )
			{
				if ( preg_match_all( "/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/i", $value, $temp_array ) )
				{
					$tmpIp = $temp_array[0];
					if ( is_array( $tmpIp ) ) $tmpIp = array_shift( $tmpIp );
					$ip_addr = $tmpIp;
					break;
				}
			}

			unset($temp_array);
			return $ip_addr;

	}

	public function getdata()
	{
		$miner_data = $this->input->get('data');//file_get_contents("php://input");

		if(strlen($miner_data)==0)
			exit;
		else
		{
		
			$miner = json_decode($miner_data);
				 

			$ip  = @$miner->ip;
			if(empty($ip))
			{
				showmsg('ip error','',2);//echo 'ip error';
				exit;
			}
			

			$ipint=bindec( decbin( ip2long( $ip) ) ); 
			
			if(!empty($miner->mac))
			$mac  = @$miner->mac;
			else
			$mac=0;
			
			$macint=@mac2int($mac);
			//if($macint=='')
			//$macint=0;
			
			
			$dev_name  = $miner->dev_name;
			$asc_mhs_av  = $miner->asc_mhs_av;
			$dev_num  = $miner->dev_num;
			$asc_mhs_5s  = $miner->asc_mhs_5s;
			$asc_mhs_5m  = $miner->asc_mhs_5m;
			$asc_mhs_15m  = $miner->asc_mhs_15m;
			$asc_last_share_time  = $miner->asc_last_share_time;
			if(@$miner->asc_elapsed)
			$asc_elapsed  = $miner->asc_elapsed;
			else
			$asc_elapsed  =1;
 
			if(@$miner->temperature)
			$temperature  = $miner->temperature;
			else
			$temperature  =0;
			
			$time =time();
	 		//echo $dev_num;
			
			//if(!empty($mac))
			//$sql="select mid from miners where  mac_address= ".$mac." limit 1";
			//else
			//$sql="select mid from miners where ipint = ".$ipint." and macint= ".$macint." limit 1";
			if($macint != 0)
			$sql="select mid from miners where macint = ".$macint." limit 1";
			else
			$sql="select mid from miners where ipint = ".$ipint." limit 1";

			$result = $this->db->query($sql);
			if(1)
			{
			if($result->num_rows()>0)
			{
			 
				//老机器
				$data = array(
	 						  'dev_name' 			=> $dev_name ,
							  'mac_address' 			=> $mac ,
							  'asc_mhs_av' 			=> $asc_mhs_av ,
							  'dev_num' 			=> $dev_num ,
							  'asc_mhs_5s' 			=> $asc_mhs_5s ,
							  'asc_mhs_5m' 			=> $asc_mhs_5m ,
							  'asc_mhs_15m' 		=> $asc_mhs_15m ,
							  'asc_last_share_time' => $asc_last_share_time ,
							  'asc_elapsed' => $asc_elapsed ,
							  
							  'temperature' => $temperature ,
							  'event_time' 			=> $time
							   

	 							
							  );
				$this->db->where('mid', $result->row()->mid);
				//if($this->db->insert('makers', $data))
				$this->db->update('miners', $data);	
				echo 'update OK.';

			}
			
			else
			{
				
				//新机器
				$data2 = array(
							  'ip_address' 			=> $ip ,
							  'mac_address' 		=> $mac ,
							  'ipint' 				=> $ipint ,
							  'macint' 				=> $macint ,
							  'dev_name' 			=> $dev_name ,
							  'asc_mhs_av' 			=> $asc_mhs_av ,
							  'dev_num' 			=> $dev_num ,
							  'asc_mhs_5s' 			=> $asc_mhs_5s ,
							  'asc_mhs_5m' 			=> $asc_mhs_5m ,
							  'asc_mhs_15m' 		=> $asc_mhs_15m ,
							  'asc_last_share_time' => $asc_last_share_time ,
							  'event_time' 			=> $time,
							  'add_time' 			=> time(),
							  'temperature' => $temperature ,
							  'asc_elapsed' 			=> $asc_elapsed	 							
							  );

				$this->db->insert('miners', $data2);
				echo 'insert ok';
			}
			}
			else
			echo 'error1';
 		
		
		}			



		exit("OK");
	
	}


	function geturl($url){ 

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 5);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);

	$result=curl_exec($ch); 
	curl_close($ch); 
	return $result;
	}
	
	public function t1_iplist()
	{
			$sql="select ip_address from t1miners where ipint >0 limit 500";
			$result = $this->db->query($sql)->result_array();
			foreach($result as $ips)
			{
				$ip_array[] = $ips['ip_address'];
			}
			echo json_encode($ip_array);
			//var_dump($result);
			
	}
	
	
	function get_commands()
	{
			$sql="select T1.ipint as ipint,CC.name AS command,CC.content AS para,CC.cid as cid from commands CC ,  t1miners T1 where T1.tid = CC.tid AND CC.status =0 limit 5";
			$result = $this->db->query($sql)->result_array();
			$jsondata = json_encode($result) ;
			//foreach($result as $key => $value)
			//{
				//$data = array(
							   //'status' => 1
								//);
				//$this->db->update('commands', $data, array('cid' => $value['cid']));

			//}
			return $jsondata;
	}
	
	function closeCommand()
	{
		$cid = $this->input->get('cid');
		$data = array(
						'status' => 1
					);
		$this->db->update('commands', $data, array('cid' => $cid));		
	}
	
	
	public function gett1data()
	{
		$miner_data = $this->input->get('data');//file_get_contents("php://input");
		if(strlen($miner_data)==0)
			exit;
		else
		{
		
			$miner = json_decode($miner_data);
				 

			$ip  = @$miner->ip;
			if(empty($ip))
			{
				showmsg('ip error','',2);//echo 'ip error';
				exit;
			}
			

			$ipint=bindec( decbin( ip2long( $ip) ) ); 
 
			$hash  = $miner->hash;
 			$dev_num  = $miner->boards;
 			$server  = $miner->server;
 			$efi  = $miner->efi;
 			$hws  = $miner->hws;
 
			$time =time();
	 		//echo $dev_num;
			
			//if(!empty($mac))
			//$sql="select mid from miners where  mac_address= ".$mac." limit 1";
			//else
			//$sql="select mid from miners where ipint = ".$ipint." and macint= ".$macint." limit 1";
 
			$sql="select tid from t1miners where ipint = ".$ipint." limit 1";

			$result = $this->db->query($sql);
			if(1)
			{
			if($result->num_rows()>0)
			{
			 
				//老机器
				$data = array(
	 						  'dev_num' 			=> $dev_num ,
							  'hash' 			=> $hash ,
							  'server' 			=> $server ,
							  'efi' 			=> $efi ,
							  'hws' 			=> $hws ,

							  'event_time' 			=> $time,
 
							  );
				$this->db->where('tid', $result->row()->tid);
				//if($this->db->insert('makers', $data))
				$this->db->update('t1miners', $data);
				//echo $time;
				echo $this->get_commands();
				//echo 'update OK.';

			}
			
			else
			{
				
				//新机器
				$data2 = array(
							  'ip_address' 			=> $ip ,
 							  'ipint' 				=> $ipint ,
 							  'dev_num' 			=> $dev_num ,
							  'hash' 			=> $hash,
							  'server' 			=> $server,
							  'event_time' 			=> $time,
 							  'efi' 			=> $efi ,
							  'hws' 			=> $hws ,
 							  );

				$this->db->insert('t1miners', $data2);
				echo $this->get_commands();
			}
			}
			else
			echo 'error1';
 		
		
		}			



		//exit("OK");
	
	}
	
	
 public function editGroups()
 {
	$gid = $this->input->get('gid');

	if(empty($gid))
	{
		//add new
			$this->form_validation->set_rules('rack', 'rack', 'trim|xss_clean');
			$this->form_validation->set_rules('start', 'start', 'trim|xss_clean');
			$this->form_validation->set_rules('end', 'end', 'trim|xss_clean');
			$this->form_validation->set_rules('name', 'name', 'trim|xss_clean');
			
			if($this->form_validation->run())
			{
	 			 
				$rack = $this->input->post('rack');
				$start = $this->input->post('start');
				$end = $this->input->post('end');
				$name = $this->input->post('name');
				$data = array(
		 						  'name' 			=> $name  ,
		 						  'rack' 			=> $rack  ,
		 						  'start' 			=> $start  ,
		 						  'end' 			=> $end  
								  );

 				$this->db->insert('groups', $data);	
				//echo 'update OK.';			
				showmsg('edit OK',WEB_ROOT,'3');
				return;	
			}
			else
			{

			//$this->data['data']=$query->row();
			//var_dump($this->data['data']);
		
	 		$this->data['title']= 'add';
	 		
			$this->load->view('common/header', $this->data);	
			//$this->load->view('common/left');	
			$this->load->view('editGroups');	
			$this->load->view('common/footer');					
			}
		
	}
	else
	{
		//edit

		$query=$this->db->get_where('groups', array('gid' => $gid));

		if($query->num_rows()>0)
		{
			$this->form_validation->set_rules('rack', 'rack', 'trim|xss_clean');
			$this->form_validation->set_rules('start', 'start', 'trim|xss_clean');
			$this->form_validation->set_rules('end', 'end', 'trim|xss_clean');
			$this->form_validation->set_rules('name', 'name', 'trim|xss_clean');
						
			if($this->form_validation->run())
			{
	 			 
				$rack = $this->input->post('rack');
				$start = $this->input->post('start');
				$end = $this->input->post('end');
				$name = $this->input->post('name');
				$data = array(
		 						  'name' 			=> $name  ,
		 						  'rack' 			=> $rack  ,
		 						  'start' 			=> $start  ,
		 						  'end' 			=> $end  
								  );

				$this->db->where('gid', $gid);
				$this->db->update('groups', $data);	
				//echo 'update OK.';			
				showmsg('edit OK',WEB_ROOT,'3');
				return;	
			}
			else
			{
			$this->data['data']=$query->row();
			//var_dump($this->data['data']);
		
	 		$this->data['title']= 'edit';
	 		
			$this->load->view('common/header', $this->data);	
			//$this->load->view('common/left');	
			$this->load->view('editGroups');	
			$this->load->view('common/footer');			

			}

	 	}
		else
		{
			showmsg('gid error  ',WEB_ROOT,'3');


		}			

	}

	
 }
 


}
 
 