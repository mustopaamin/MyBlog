<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function menu_list()
{
	$ci =& get_instance();
	$menu = $ci->db->get_where('t_module',array('f_module_active'=>1));

	$result = array();
	$result1 = array();
	$result2 = array();
	if($menu->num_rows()>0)
	{
		foreach($menu->result_array() as $k => $v):
			$result1[$v['f_module_level']][$v['f_module_parent']][$v['f_module_id']] = array(
				'code' => $v['f_module_class'],'name' => $v['f_module_name'],
				'icon' => $v['f_module_icon'],'parent' => $v['f_module_parent'],
			);
		endforeach;

		foreach($menu->result_array() as $k => $v):
			$result2[$v['f_module_level']][$v['f_module_parent']][] = $v['f_module_name'];
		endforeach;
		
		$result['r1'] = $result1;
		$result['r2'] = $result2;
	}
	
	$html = "";
	foreach($result1[0][0] as $a => $b):
		$href = ($b['code'] != '') ? site_url($b['code']): "javascript:void(0)";
		$html .="<li class=\"treeview\"><a href=\"".$href."\"><i class=\"".$b['icon']."\"></i><span>".$b['name']."</span>";
		// Cek level 1
		if(is_array($result1[1][$a]) == 1)
		{
			$html .="<i class=\"fa fa-angle-left pull-right\"></i></a><ul class=\"treeview-menu\">";
			foreach($result1[1][$a] as $c => $d):
				$href1 = ($d['code']) ? site_url($d['code']): "javascript:void(0)";
				$html .="<li class=\"treeview\"><a href=\"".$href1."\"><i class=\"".$d['icon']."\"></i><span>".$d['name']."</span>";
				// Cek Level 2
				if(is_array($result1[2][$c]) == 1)
				{
					$html .="<i class=\"fa fa-angle-left pull-right\"></i></a><ul class=\"treeview-menu\">";
					foreach($result1[2][$c] as $e => $f):
						$href2 = ($f['code']) ? site_url($f['code']): "javascript:void(0)";
						$html .="<li class=\"treeview\"><a href=\"".$href2."\"><i class=\"".$f['icon']."\"></i><span>".$f['name']."</span>";
						// Cek Level 3
						if(is_array($result1[3][$e]) == 1)
						{
							$html .="<i class=\"fa fa-angle-left pull-right\"></i></a><ul class=\"treeview-menu\">";
							foreach($result1[3][$e] as $g => $h):
								$href3 = ($h['code']) ? site_url($h['code']): "javascript:void(0)";
								$html .="<li class=\"treeview\"><a href=\"".$href3."\"><i class=\"".$h['icon']."\"></i><span>".$h['name']."</span></a></li>";
							endforeach;
							$html .="</ul>";
						}
						else
						{
							$html .= "</a>";
						}
						$html .="</li>";
					endforeach;
					$html .="</ul>";
				}
				else
				{
					$html .= "</a>";
				}
				$html .="</li>";
			endforeach;
			$html .="</ul>";
		}
		else
		{
			$html .= "</a>";
		}
		$html .="</li>";
	endforeach;	
	
	return $html;
}

function menu($d = array(),$u)
{
	$ci =& get_instance();
	if(in_array($ci->uri->segment($u),$d, true)) return 'active';
}

function submenu($d = null,$u)
{
	$ci =& get_instance();
	if($ci->uri->segment($u) == $d) return 'class="active"';
}

function menu1($d = array(),$u,$uri1)
{
	$ci =& get_instance();
	if(in_array($ci->uri->segment($u),$d, true)  && $ci->uri->segment(1) == $uri1) return 'active';
}

function submenu1($d = null,$u,$uri1)
{
	$ci =& get_instance();
	if($ci->uri->segment($u) == $d && $ci->uri->segment(1) == $uri1) return 'class="active"';
}

function array_sort($array, $on, $order=SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}

function my_array_merge($array1, $array2) {
    $result = Array();
    foreach($array1 as $key => $value) {
        $result[$key] = array_merge($value, $array2[$key]);
    }
    return $result;
}

function seo_title($s) {
    $c = array (' ');
    $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+');

    $s = str_replace($d, '', $s); // Hilangkan karakter yang telah disebutkan di array $d
    
    $s = strtolower(str_replace($c, '-', $s)); // Ganti spasi dengan tanda - dan ubah hurufnya menjadi kecil semua
    return $s;
}

function tgl_indo($tgl){
	$tanggal = substr($tgl,8,2);
	$bulan = getBulan(substr($tgl,5,2));
	$tahun = substr($tgl,0,4);
	return $tanggal.' '.$bulan.' '.$tahun;
}

function getBulan($bln){
	switch ($bln){
		case 1: 
			return "Januari";
			break;
		case 2:
			return "Februari";
			break;
		case 3:
			return "Maret";
			break;
		case 4:
			return "April";
			break;
		case 5:
			return "Mei";
			break;
		case 6:
			return "Juni";
			break;
		case 7:
			return "Juli";
			break;
		case 8:
			return "Agustus";
			break;
		case 9:
			return "September";
			break;
		case 10:
			return "Oktober";
			break;
		case 11:
			return "November";
			break;
		case 12:
			return "Desember";
			break;
	}
}
