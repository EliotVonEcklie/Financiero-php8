// JavaScript Document
// ************** ESTE ES EL CALENDARIO **********
	var fc_ie = false;
	if (document.all) { fc_ie = true; }
	
	var calendars = Array();
	var fc_months = Array('Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic');
	var fc_openCal;

	var fc_calCount = 0;
	
	function getCalendar(fieldId) {
		return calendars[fieldId];
	}
	
	function displayCalendarFor(fieldId) {
		var formElement = fc_getObj(fieldId);
		displayCalendar(formElement);
	}
	
	function displayCalendar(formElement) {
		if (!formElement.id) {
			formElement.id = fc_calCount++;
		} 
		var cal = calendars[formElement.id];
		if (typeof(cal) == 'undefined') {
			cal = new floobleCalendar();
			cal.setElement(formElement);
			calendars[formElement.id] = cal;
		}
		if (cal.shown) {
			cal.hide();
		} else {
			cal.show();
		}
	}
	
	function display3FieldCalendar(me, de, ye) {
		if (!me.id) { me.id = fc_calCount++; }
		if (!de.id) { de.id = fc_calCount++; }
		if (!ye.id) { ye.id = fc_calCount++; }
		var id = me.id + '-' + de.id + '-' + ye.id;
		var cal = calendars[id];
		if (typeof(cal) == 'undefined') {
			cal = new floobleCalendar();
			cal.setElements(me, de, ye);
			calendars[id] = cal;
		}
		if (cal.shown) {
			cal.hide();
		} else {
			cal.show();
		}
	}

	//--Class Stuff--------------------------------------------------
	function floobleCalendar() {
		// Define Methods
		this.setElement = fc_setElement;
		this.setElements = fc_setElements;
		this.parseDate = fc_parseDate;
		this.generateHTML = fc_generateHTML;
		this.show = fc_show;
		this.hide = fc_hide;
		this.moveMonth = fc_moveMonth;
		this.setDate = fc_setDate;
		this.formatDate = fc_formatDate;
		this.setDateFields = fc_setDateFields;
		this.parseDateFields = fc_parseDateFields;
		this.selMonth = opcion_sel_mes;
		this.selYear = opcion_sel_anio;
		
		this.shown = false;
	}
	
	function fc_setElement(formElement) {
		this.element = formElement;
		this.format = this.element.title;
		this.value = this.element.value;
		this.id = this.element.id;
		this.mode = 1;
	}
	
	function fc_setElements(monthElement, dayElement, yearElement) {
		this.mElement = monthElement;
		this.dElement = dayElement;
		this.yElement = yearElement;
		this.id = this.mElement.id + '-' + this.dElement.id + '-' + this.yElement.id;
		this.element = this.mElement;
		if (fc_absoluteOffsetLeft(this.dElement) < fc_absoluteOffsetLeft(this.element)) {
			this.element = this.dElement;
		}
		if (fc_absoluteOffsetLeft(this.yElement) < fc_absoluteOffsetLeft(this.element)) {
			this.element = this.yElement;
		}
		if (fc_absoluteOffsetTop(this.mElement) > fc_absoluteOffsetTop(this.element)) {
			this.element = this.mElement;
		}
		if (fc_absoluteOffsetTop(this.dElement) > fc_absoluteOffsetTop(this.element)) {
			this.element = this.dElement;
		}
		if (fc_absoluteOffsetTop(this.yElement) > fc_absoluteOffsetTop(this.element)) {
			this.element = this.yElement;
		}

		this.mode = 2;
	}
	
	function fc_parseDate() {
		if (this.element.value) {
			this.date = new Date();
			var out = '';
			var token = '';
			var lastCh, ch;
			var start = 0;
			lastCh = this.format.substring(0, 1);
			for (i = 0; i < this.format.length; i++) {
				ch = this.format.substring(i, i+1);
				if (ch == lastCh) { 
					token += ch;
				} else {
					fc_parseToken(this.date, token, this.element.value, start);
					start += token.length;
					token = ch;
				}
				lastCh = ch;
			}
			fc_parseToken(this.date, token, this.element.value, start);

		} else {
			this.date = new Date();
		}
		if ('' + this.date.getMonth() == 'NaN') {
			this.date = new Date();
		}
	}	
	
	function fc_parseDateFields() {
		this.date = new Date();
		if (this.mElement.value) this.date.setMonth(fc_getFieldValue(this.mElement) - 1);
		if (this.dElement.value) this.date.setDate(fc_getFieldValue(this.dElement));
		if (this.yElement.value) this.date.setFullYear(fc_getFieldValue(this.yElement));
		if ('' + this.date.getMonth() == 'NaN') {
			this.date = new Date();
		}
	}
	/**
	 * 
	 * @param {*} d 
	 * @param {*} m 
	 * @param {*} y  envio de datos a input
	 */
	
	function fc_setDate(d, m, y) {
		this.date.setYear(y);
		this.date.setMonth(m);
		this.date.setDate(d);
		if (this.date.setMonth(m)==5) {
			this.date.setMonth(5);
		}
		if (this.mode == 1) {
			this.element.value = this.formatDate();
		} else {
			this.setDateFields();
		}
		this.hide();
	}
	
	function fc_setDateFields() {
		fc_setFieldValue(this.mElement, fc_zeroPad(this.date.getMonth() + 1));
		fc_setFieldValue(this.dElement, fc_zeroPad(this.date.getDate()));
		fc_setFieldValue(this.yElement, this.date.getFullYear());
	}
	
	function fc_formatDate() {
		var out = '';
		var token = '';
		var lastCh, ch;
		lastCh = this.format.substring(0, 1);
		for (i = 0; i < this.format.length; i++) {
			ch = this.format.substring(i, i+1);
			if (ch == lastCh) { 
				token += ch;
			} else {
				out += fc_formatToken(this.date, token);
				token = ch;
			}
			lastCh = ch;
		}
		out += fc_formatToken(this.date, token);
		return out;
	}
	
	function fc_show() {
		if (typeof(fc_openCal) != 'undefined') { fc_openCal.hide(); }
	
		if (this.mode == 1) {
			this.parseDate();
		} else {
			this.parseDateFields();
		}
		this.showDate = new Date(this.date.getTime());
		if (typeof(this.div) != 'undefined') {
			this.div.innerHTML = this.generateHTML();
		}
		
		if (typeof(this.div) == 'undefined') {
			this.div = document.createElement('DIV');
			this.div.style.position = 'absolute';
			this.div.style.display = 'none';
			this.div.className = 'fc_main';
			this.div.innerHTML = this.generateHTML();
			this.div.style.left = fc_absoluteOffsetLeft(this.element);
			this.div.style.top = fc_absoluteOffsetTop(this.element) + this.element.offsetHeight + 1;
			document.body.appendChild(this.div);
		}
		this.div.style.display = 'block';
		this.div.style.height = '200px';
		this.div.style.width = '310px';
		this.shown = true;
		fc_openCal = this;
	}
	
	function fc_generateHTML() {
		var my;
		var actual=new Date();
		var html = '<TABLE style="width:97%; margin: 0 auto;"><tr><td colspan="6" height="10px"></td></tr><TR><TD CLASS="fc_head" COLSPAN="4"><DIV STYLE="float: right"></DIV><i class="fa fa-calendar fa-lg"></i> Calendario:</TD><td colspan="2"><div id="imgcal" align="center"><img src="imagenes/spid_cal.png" width="80px" height="25px"></div></td><TD CLASS="fc_date" onMouseover="this.className = \'fc_dateHover\';" onMouseout="this.className=\'fc_date\';" onClick="getCalendar(\'' + this.id + '\').hide();"><B>X</B></TD></TR>';
		html += '<TR><TD CLASS="fc_date" onMouseover="this.className = \'fc_dateHover\';" onMouseout="this.className=\'fc_date\';" onClick="getCalendar(\'' + this.id + '\').moveMonth(-12);"><B><<</B></TD><TD CLASS="fc_date" onMouseover="this.className = \'fc_dateHover\';" onMouseout="this.className=\'fc_date\';" onClick="getCalendar(\'' + this.id + '\').moveMonth(-1);"><B><</B></TD>';
		html+='<TD COLSPAN="3" CLASS="fc_wk"><select id="cal_months'+ this.id +'" class="sl_date" onchange="getCalendar(\'' + this.id + '\').selMonth(cal_months'+ this.id +')">'; 
		for(my=0;my<this.showDate.getMonth();my++){ 
			html+='<option value="'+ my +'">' + fc_months[my] +'</option>'; 
		} 
		html+='<option value="'+ this.showDate.getMonth() +'" selected="selected">' + fc_months[this.showDate.getMonth()] + '</option>';
		for(my=(this.showDate.getMonth()+1);my<fc_months.length;my++){ 
			html+='<option value="'+ my +'">' + fc_months[my] +'</option>'; 
		} 
		html+='</select><select id="cal_years'+ this.id +'" class="sl_date" onchange="getCalendar(\'' + this.id + '\').selYear(cal_years'+ this.id +')">'; 
		for(my=(actual.getFullYear()+10);my>1940;my--){
			if(my==fc_getYear(this.showDate)){
				var selected='selected="selected"';
			}
			else{
				var selected='';
			}
			html+='<option value="'+ my +'" '+ selected +'>' + my +'</option>'; 
		} 
		html+='<option value="'+ fc_getYear(this.showDate) +'" selected="selected">' + fc_getYear(this.showDate) +'</option>'; 
		html+='</select></TD><TD CLASS="fc_date" onMouseover="this.className = \'fc_dateHover\';" onMouseout="this.className=\'fc_date\';" onClick="getCalendar(\'' + this.id + '\').moveMonth(1);"><B>></B></TD><TD CLASS="fc_date" onMouseover="this.className = \'fc_dateHover\';" onMouseout="this.className=\'fc_date\';" onClick="getCalendar(\'' + this.id + '\').moveMonth(12);"><B>>></B></TD></TR>';
		html += '<TR><TD WIDTH="14%" CLASS="fc_wk">Lu</TD><TD WIDTH="14%" CLASS="fc_wk">Ma</TD><TD WIDTH="14%" CLASS="fc_wk">Mi</TD><TD WIDTH="14%" CLASS="fc_wk">Ju</TD><TD WIDTH="14%" CLASS="fc_wk">Vi</TD><TD class="fc_wknd" WIDTH="14%">Sa</TD><TD class="fc_wknd" WIDTH="14%">Do</TD></TR>';
		html += '<TR>';
		var dow = 0;
		var i, style;
		var totald = fc_monthLength(this.showDate);
		for (i = 0; i < fc_firstDOW(this.showDate); i++) {
			dow++;
			html += '<TD> </TD>';
		}
		for (i = 1; i <= totald; i++) {

			if (dow == 0) { html += '<TR>'; }
			if (this.showDate.getMonth() == this.date.getMonth() && this.showDate.getYear() == this.date.getYear() && this.date.getDate() == i) { 
				style = ' style="font-weight: bold;"';
			} else {
				style = '';
			}
			var mes = this.showDate.getMonth();

			html += '<TD CLASS="fc_date" onMouseover="this.className = \'fc_dateHover\';" onMouseout="this.className=\'fc_date\';" onClick="getCalendar(\'' + this.id + '\').setDate(' + i + ', ' + mes + ', ' + this.showDate.getFullYear() + ');" ' + style + '>' + i + '</TD>';
			dow++;
			if (dow == 7) {
				html += '</TR>';
				dow = 0;
			}
		}
		if (dow != 0) {
			for (i = dow; i < 7; i++) {
				html += '<TD> </TD>';
			}
		}
		html +='</TR>';
		html += '</TABLE>';
		return html;
	}
	
	function fc_hide() {
		if (this.div != false) {
			this.div.style.display = 'none';
		}
		this.shown = false;
		fc_openCal = undefined;
	}

	function opcion_sel_mes(dato) {
		var mes=dato.value;
		this.showDate.setMonth(mes);
		this.div.innerHTML = this.generateHTML();
	}
	
	function opcion_sel_anio(dato) {
		var anio=dato.value;
		this.showDate.setYear(anio);
		this.div.innerHTML = this.generateHTML();
	}
	/**
	 * Funcion para cambiar de mes a mes 
	 * y año a a año
	 * 
	 */
	function fc_moveMonth(amount) {
		var m = this.showDate.getMonth();
		var y = fc_getYear(this.showDate);
		if (amount == 1) {
			if (m == 0
				|| m == 2
				|| m == 4
				|| m == 6
				|| m == 7
				|| m == 9
				|| m == 11) {
				this.showDate.setMonth(m + 1);
			}
			if (m == 11) {
				this.showDate.setMonth(0);
				this.showDate.setYear(y + 1);
			} else {
				this.showDate.setMonth(m + 1);
			}
		} else if (amount == -1)  {
			if (m == 0)  {
				this.showDate.setMonth(11);
				this.showDate.setYear(y - 1);
			} else {
				this.showDate.setMonth(m - 1);
			}
		} else if (amount == 12) {
			this.showDate.setYear(y + 1);
		} else if (amount == -12) {
			this.showDate.setYear(y - 1);
		}
		this.div.innerHTML = this.generateHTML();
	}
	
	//--Utils-------------------------------------------------------------
	function fc_absoluteOffsetTop(obj) {
     	var top = obj.offsetTop;
     	var parent = obj.offsetParent;
     	while (parent != document.body) {
     		top += parent.offsetTop;
     		parent = parent.offsetParent;
     	}
     	return top;
     }
     
     function fc_absoluteOffsetLeft(obj) {
     	var left = obj.offsetLeft;
     	var parent = obj.offsetParent;
     	while (parent != document.body) {
     		left += parent.offsetLeft;
     		parent = parent.offsetParent;
     	}
     	return left;
     }
     
     function fc_firstDOW(date) {
     	var dow = date.getDay();
     	var day = date.getDate();
 		if (day % 7 == 0) return dow;
     	return (7 + dow - (day % 7)) % 7; 
     }
     
     function fc_getYear(date) {
     	var y = date.getYear();
     	if (y > 1900) return y;
     	return 1900 + y;
	 }
	 
	 /**
	  * Dias del segun el mes
	  * 
	  */
     
     function fc_monthLength(date) {
		var month = date.getMonth();
		var totald = 30;
		 if (month == 0
			 || month == 2
			 || month == 4
			 || month == 6
			 || month == 7
			 || month == 9
			 || month == 11) { totald = 31; }
		if (month == 1) {
			var year = date.getYear();
			if (year % 4 == 0 && (year % 400 == 0 || year % 100 != 0)) {
				totald = 29; 
			} else {
				totald = 28; 
			}
		}
		return totald;
     }
     
     function fc_formatToken(date, token) {
		var command = token.substring(0, 1);
		if (command == 'y' || command == 'Y') {
			if (token.length == 2) { return fc_zeroPad(date.getFullYear() % 100); }
			if (token.length == 4) { return date.getFullYear(); } 
		}
		if (command == 'd' || command == 'D') {
			if (token.length == 2) { return fc_zeroPad(date.getDate()); }
		}
		if (command == 'm' || command == 'M') {
			if (token.length == 2) { return fc_zeroPad(date.getMonth() + 1); }
			if (token.length == 3) { return fc_months[date.getMonth()]; } 
		}
		return token;
     }
     
     function fc_parseToken(date, token, value, start) {
		var command = token.substring(0, 1);
		var v;
		if (command == 'y' || command == 'Y') {
			if (token.length == 2) { 
				v = value.substring(start, start + 2);
				if (v < 70) { date.setFullYear(2000 + parseInt(v)); } else { date.setFullYear(1900 + parseInt(v)); } 
			}
			if (token.length == 4) { v = value.substring(start, start + 4); date.setFullYear(v);} 
		}
		if (command == 'd' || command == 'D') {
			if (token.length == 2) { v = value.substring(start, start + 2); date.setDate(v); }
		}
		if (command == 'm' || command == 'M') {
			if (token.length == 2) { v = value.substring(start, start + 2); date.setMonth(v - 1); }
			if (token.length == 3) { 
				v = value.substring(start, start + 3);
				var i;
				for (i = 0; i < fc_months.length; i++) {
					if (fc_months[i].toUpperCase() == v.toUpperCase()) { date.setMonth(i); }
				}
			} 
		}
     }
     
     function fc_zeroPad(num) {
		if (num < 10) { return '0' + num; }
		return num;
     }

	function fc_getObj(id) {
		if (fc_ie) { return document.all[id]; } 
		else { return document.getElementById(id);	}
	}

      function fc_setFieldValue(field, value) {
                if (field.type.substring(0,6) == 'select') {
                        var i;
                        for (i = 0; i < field.options.length; i++) {
                                if (fc_equals(field.options[i].value, value)) {
                                        field.selectedIndex = i;
                                }
                        }
                } else {
                        field.value = value;
                }
      }

      function fc_getFieldValue(field) {
                if (field.type.substring(0,6) == 'select') {
                        return field.options[field.selectedIndex].value;
                } else {
                        return field.value;
                }
      }
      
      function fc_equals(val1, val2) {
      		if (val1 == val2) return true;      		
      		if (1 * val1 == 1 * val2) return true;
      		return false;
      }

