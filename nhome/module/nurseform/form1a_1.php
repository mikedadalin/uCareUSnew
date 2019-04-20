<?php
include('../../class/DB.php');
include('../../class/function.php');
?>
<html>
<head>
<script type="text/javascript" src="../../js/go.js"></script>
<script type="text/javascript" src="../../js/geno.js"></script>
<script type="text/javascript" id="code">
		
	function newPerson(strPerson, titleIndex, index, son, sonInLaw, daughter, daughterInLaw, grandSon, grandDaughter) {
		var srcP = strPerson.split(':');
		var id = srcP[0];
		var relationCode = srcP[1].split('-')[0];
		var rank = srcP[1].split('-')[1];
		var live = srcP[2];
		var gender = srcP[3];
		var age = srcP[4];
		var work = srcP[5];
		var p = new Array();
		p['key'] = id;
		
		if(typeof gender != 'undefined') {
			if(gender == '1') p['s'] = "M";
			else if(gender == '2') p['s'] = "F";
		}
		
		if(typeof rank != 'undefined') p['rank'] = rank;
		
		switch(relationCode) {
		case '5':	// Father
			p['n'] = 'Father';
			titleIndex['Father'] = index;
			if(typeof gender == 'undefined') p['s'] = "M";
			break;
		case '9':	// Mother
			p['n'] = 'Mother';
			titleIndex['Mother'] = index;
			if(typeof gender == 'undefined') p['s'] = "F";
			break;
		case '12':	// Older brother
			p['n'] = 'Older brother';
			if(typeof gender == 'undefined') p['s'] = "M";
			break;
		case '13':	// Older sister
			p['n'] = 'Older sister';
			if(typeof gender == 'undefined') p['s'] = "F";
			break;
		case '14':	// Younger brother
			p['n'] = 'Younger brother';
			if(typeof gender == 'undefined') p['s'] = "M";
			break;
		case '15':	// Younger sister
			p['n'] = 'Younger sister';
			if(typeof gender == 'undefined') p['s'] = "F";
			break;
		case '16':	// Spouse
			p['n'] = 'Spouse';
			titleIndex['Spouse'] = index;
			break;
		case '17':	// Son
			p['n'] = 'Son';
			if(typeof gender == 'undefined') p['s'] = "M";
			son.push(index);
			break;
		case '18':	// Daughter
			p['n'] = 'Daughter';
			if(typeof gender == 'undefined') p['s'] = "F";
			daughter.push(index);
			break;
		case '20':	// Son in law
			p['n'] = 'Son in law';
			if(typeof gender == 'undefined') p['s'] = "M";
			sonInLaw.push(index);
			break;
		case '21':	// Daughter in law
			p['n'] = 'Daughter in law';
			if(typeof gender == 'undefined') p['s'] = "F";
			daughterInLaw.push(index);
			break;
		case '22':	// Grandson
			p['n'] = 'Grandson';
			if(typeof gender == 'undefined') p['s'] = "M";
			grandSon.push(index);
			break;
		case '23':	// Granddaughter
			p['n'] = 'Granddaughter';
			if(typeof gender == 'undefined') p['s'] = "F";
			grandDaughter.push(index);
			break;
		case '26':	// Personal aide
			p['n'] = 'Personal aide';
			break;
		case '27':	// Friend
			p['n'] = 'Friend';
			break;
		case '28':	// Nursing home
			p['n'] = 'Nursing home';
			break;
		case '29':	// Foundation's staff
			p['n'] = 'Foundation\'s staff';
			break;
		case '30':	// Caregivers 
			p['n'] = 'Caregivers';
			break;
		case '99':	// 沒有配偶
			p['n'] = 'Spouse';
			titleIndex['Spouse'] = index;
			p['s'] += "NS";
			break;
		default:
			break;
		}
		p['age'] = age;
		p['work'] = work;
		if(live == '0') p['s'] = "D" + p['s'];

		return p;
	}
	
	function connectPeople(people, titleIndex, son, sonInLaw, daughter, daughterInLaw, grandSon, grandDaughter) {
		for(var i = 0; i < people.length; i++) {
			var p = people[i];
			var title = p['n'];
			switch(title) {
			case 'Resident':
				if(typeof titleIndex['Spouse'] != 'undefined') {
					var mate = people[titleIndex['Spouse']];
					if(p['s'] == "M" || p['s'] == "SM" || p['s'] == "DM") {
						p['ux'] = mate['key'];
					} else {
						p['vir'] = mate['key'];
					}
				}
				if(typeof titleIndex['Father'] != 'undefined') {
					p['f'] = people[titleIndex['Father']]['key'];
				}
				if(typeof titleIndex['Mother'] != 'undefined') {
					p['m'] = people[titleIndex['Mother']]['key'];
				}
				break;
			case 'Father':
				if(typeof titleIndex['Mother'] != 'undefined') {
					p['ux'] = people[titleIndex['Mother']]['key'];
				}
				break;
			case 'Mother':
				if(typeof titleIndex['Father'] != 'undefined') {
					p['vir'] = people[titleIndex['Father']]['key'];
				}
				break;
			case 'Older brother':
			case 'Older sister':
			case 'Younger brother':
			case 'Younger sister':
				if(typeof titleIndex['Father'] != 'undefined') {
					p['f'] = people[titleIndex['Father']]['key'];
				}
				if(typeof titleIndex['Mother'] != 'undefined') {
					p['m'] = people[titleIndex['Mother']]['key'];
				}
				break;
			case 'Spouse':
				var mate = people[titleIndex['Resident']];
				if(p['s'] == "M" || p['s'] == "SM" || p['s'] == "DM") {
					p['ux'] = mate['key'];
				} else {
					p['vir'] = mate['key'];
				}
				break;
			case 'Son':
				var parent1 = people[titleIndex['Resident']];
				var parent2 = people[titleIndex['Spouse']];
				if(parent1['s'] == "M" || parent1['s'] == "SM" || parent1['s'] == "DM")
					p['f'] = parent1['key'];
				else if (parent1['s'] == "F" || parent1['s'] == "SF" || parent1['s'] == "DF")
					p['m'] = parent1['key'];
				if(typeof parent2 != 'undefined') {
					if(parent2['s'] == "M" || parent2['s'] == "SM" || parent2['s'] == "DM")
						p['f'] = parent2['key'];
					else if (parent2['s'] == "F" || parent2['s'] == "SF" || parent2['s'] == "DF")
						p['m'] = parent2['key'];
				}
				// Daughter in law
				for(var j = 0; j < daughterInLaw.length; j++) {
					if(people[daughterInLaw[j]]['rank'] == p['rank']) {
						p['ux'] = people[daughterInLaw[j]]['key'];
						break;
					}
				}
				break;
			case 'Daughter':
				var parent1 = people[titleIndex['Resident']];
				var parent2 = people[titleIndex['Spouse']];
				if(parent1['s'] == "M" || parent1['s'] == "SM" || parent1['s'] == "DM")
					p['f'] = parent1['key'];
				else if (parent1['s'] == "F" || parent1['s'] == "SF" || parent1['s'] == "DF")
					p['m'] = parent1['key'];
				if(typeof parent2 != 'undefined') {
					if(parent2['s'] == "M" || parent2['s'] == "SM" || parent2['s'] == "DM")
						p['f'] = parent2['key'];
					else if (parent2['s'] == "F" || parent2['s'] == "SF" || parent2['s'] == "DF")
						p['m'] = parent2['key'];
				}
				// Son in law
				for(var j = 0; j < sonInLaw.length; j++) {
					if(people[sonInLaw[j]]['rank'] == p['rank']) {
						p['vir'] = people[sonInLaw[j]]['key'];
						break;
					}
				}
				break;
			case 'Son in law':
				// Daughter
				for(var j = 0; j < daughter.length; j++) {
					if(people[daughter[j]]['rank'] == p['rank']) {
						p['ux'] = people[daughter[j]]['key'];
						break;
					}
				}
				break;
			case 'Daughter in law':
				// Son
				for(var j = 0; j < son.length; j++) {
					if(people[son[j]]['rank'] == p['rank']) {
						p['vir'] = people[son[j]]['key'];
						break;
					}
				}
				break;
			case 'Grandson':
			case 'Granddaughter':
				var hit = false;
				for(var j = 0; j < son.length; j++) {
					if(people[son[j]]['rank'] == p['rank']) {
						p['f'] = people[son[j]]['key'];
						for(var k = 0; k < daughterInLaw.length; k++) {
							if(people[daughterInLaw[k]]['rank'] == p['rank']) {
								p['m'] = people[daughterInLaw[k]]['key'];
								break;
							}
						}
						hit = true;
						break;
					}
				}
				if(!hit) {
					for(var j = 0; j < daughter.length; j++) {
						if(people[daughter[j]]['rank'] == p['rank']) {
							p['m'] = people[daughter[j]]['key'];
							for(var k = 0; k < sonInLaw.length; k++) {
								if(people[sonInLaw[k]]['rank'] == p['rank']) {
									p['f'] = people[sonInLaw[k]]['key'];
									break;
								}
							}
							hit = true;
							break;
						}
					}
				}
				break;
			case 'Personal aide':
				break;
			case 'Friend':
				break;
			case 'Nursing home':
				break;
			case 'Foundation\'s staff':
				break;
			case 'Caregivers':
				break;
			default:
				break;
			}
		}
	}
	
	function drawTree(str) {
		// NOTE:
		// str格式為  (人;)*  (一個人配一個分號在後面)
		//         人 := key:關係碼[-排行]:存歿[:Gender]
		//         關係碼 := 5|9| .... | 30 (你給的那些)
		//		   排行 := 數字
		//		   存歿 := 0|1  (0是歿, 1是存)
		//         Gender := 1|2  (1是男生, 2是女生)
		// 說明如下:
		// 代碼17,18,20,21要跟一個 - 符號, 在代碼後面, 代表排行, 兒子媳婦/女兒女婿 同排行則代表為夫妻,
		// 代碼22,23要跟一個 - 符號, 在代碼後面, 代表父母排行
		// 存歿在第三欄
		// 性別在第四欄, Spouse, Caregivers, 安養院人員, Friend, Personal aide 這幾個關係一定要填, 其他是選填,程式會按照傳統男女關係自動帶入預設性別(也可以強制設定性別)
		
		//str = '0:16:1:2;1:17-1:1;2:18-2:1;3:12:1;4:5:1:2;5:9:1;6:13:1;7:14:0;8:15:0;9:30:1:1;10:17-3:1;11:18-4:1;12:20-4:1;13:21-3:1;14:22-4:1;15:23-4:1;'; 
		
		srcPeople = str.split(';');
		
		var people = new Array();
		var titleIndex = new Array();
		var son = new Array();
		var sonInLaw = new Array();
		var daughter = new Array();
		var daughterInLaw = new Array();
		var grandSon = new Array();
		var grandDaughter = new Array();
		
		// Resident
		var p = new Array();
		p['key'] = -1;
		p['n'] = "Resident";
		titleIndex['Resident'] = people.length;
		people.push(p);

		for(var i = 0; i < srcPeople.length - 1; i++) {
			var p = newPerson(srcPeople[i], titleIndex, i+1, son, sonInLaw, daughter, daughterInLaw, grandSon, grandDaughter);
			people.push(p);
		}

		var mateIndex = titleIndex['Spouse']
		if(typeof mateIndex != 'undefined') {
			if(people[mateIndex]['s'].indexOf('M') >= 0) {
				people[titleIndex['Resident']]['s'] = "SF"; 	// NOTE: Please modify: change "F" to "DF"; 
			} else if(people[mateIndex]['s'].indexOf('F') >= 0) {
				people[titleIndex['Resident']]['s'] = "SM";	// NOTE: Please modify: change "M" to "DM"; 
			}
		}
		
		connectPeople(people, titleIndex, son, sonInLaw, daughter, daughterInLaw, grandSon, grandDaughter);		
		
		var diagramStr = "[";
		for(var i = 0; i < people.length; i++) {
			var ageTxt = " - ";
			var workTxt = " - ";
			var p = new Array();
			if (typeof people[i]['age']!= 'undefined') { if (people[i]['age']!="") { ageTxt = people[i]['age']; } }
			if (typeof people[i]['work']!= 'undefined') {  if (people[i]['work']!="") { workTxt = people[i]['work']; } }
			if(typeof people[i]['key'] != 'undefined') diagramStr += "{ \"key\":" + people[i]['key'] + ",";
			if(typeof people[i]['s'] != 'undefined') diagramStr += "\"s\": \"" + people[i]['s'] + "\","; 
			if(typeof people[i]['m'] != 'undefined') diagramStr += "\"m\":" + people[i]['m'] + ",";
			if(typeof people[i]['f'] != 'undefined') diagramStr += "\"f\":" + people[i]['f'] + ",";
			if(typeof people[i]['ux'] != 'undefined') diagramStr += "\"ux\":" + people[i]['ux'] + ",";
			if(typeof people[i]['vir'] != 'undefined') diagramStr += "\"vir\":" + people[i]['vir'] + ",";
			if(typeof people[i]['n'] != 'undefined') diagramStr += "\"n\": \"" + people[i]['n'] + "\\n[" + ageTxt + "/" + workTxt + "]"  + "\""; 
			
			if(i != people.length - 1) diagramStr += "},";
			else diagramStr += "}";
			
		}
		diagramStr += "]";
		//alert(diagramStr);	// NOTE : diagramStr is the final array passed to setupDiagram in string form. 
		setupDiagram(myDiagram, JSON.parse(diagramStr));
	}
</script>
<?php
if ($_GET['date']!='') {
	$where = " AND `date`='".mysql_escape_string($_GET['date'])."'";
} else {
	$where = " ORDER BY `date` DESC LIMIT 0,1";
}
$db = new DB;
$db->query("SELECT * FROM `nurseform01a` WHERE `HospNo`='".$HospNo."'".$where);
if ($db->num_rows()>0) {
	$r = $db->fetch_assoc();
	foreach ($r as $k=>$v) { ${$k} = $v; }
}
$mateExist = 0;
$mateSex = "";
for ($i=0;$i<18;$i++) {
	if (${'Qrelate'.$i}!='') {
		if (${'Qrelate'.$i}=='16') {
			$mateExist++;
		}
		$treetxt .= $i.':'.${'Qrelate'.$i};
		$relateno = ${'Qrelate'.$i};
		if ($relateno==17 || $relateno==18 || $relateno==20 || $relateno==21) {
			if (${'Qrank'.$i}!='') { $treetxt .= '-'.${'Qrank'.$i}; }
		}
		if ($relateno==22 || $relateno==23) {
			if (${'Qprank'.$i}!='') { $treetxt .= '-'.${'Qprank'.$i}; }
		}
		if (${'Qalive'.$i.'_1'}==1) { $treetxt .= ':1'; } elseif (${'Qalive'.$i.'_2'}==1) { $treetxt .= ':0'; }
		if (${'Qgender'.$i.'_1'}==1) { $treetxt .= ':1'; } elseif (${'Qgender'.$i.'_2'}==1) { $treetxt .= ':2'; }
		$treetxt .= ':'.${'Qage'.$i};
		$treetxt .= ':'.${'Qwork'.$i}.';';
	}
}
if ($mateExist==0) {
	$subject_sex = checkgender($_GET['pid']);
	if ($subject_sex=="Male") { $mateSex = 2; } elseif ($subject_sex=="Female") { $mateSex = 1; }
	$treetxt .= $i.':99:1:1:'.$mateSex.'::;';
}
?>
<style>
@media print {
	#myDiagram {
		width:930px !important;
	}
}
</style>
</head>
<body onLoad="init(); drawTree('<?php echo $treetxt; ?>')" style="overflow-y:hidden;">
<h3 style="font-family:'微軟正黑體'">Family tree</h3>
<div id="myDiagram" style="border: solid 2px; width:880px; height:420px">
</div>
</body>
</html>
