/* danielkanangina/intlInputPhone
*  VERSION  0.0.1
*  LICENSE MIT
*
* */
if (typeof jQuery === 'undefined') {
  throw new Error('IntlInputPhoneNumber JavaScript requires jQuery')
}

(function($) {
	var country_code = $('#country_code').val();
	var msg_phone_number = $('.msg_phone_number').val();

	var IntlInputPhone = function(element, options) {
		this.element = element
		this.preferred_country = typeof options != 'undefined' ? options.preferred_country : [country_code]
		this.display_error = typeof options != 'undefined' ? options.display_error : 'on'
		this.error_message = typeof options != 'undefined' ? options.error_message : IntlInputPhone.DEFAULTS.error_message
	}

	IntlInputPhone.VERSION = '0.0.1'
	IntlInputPhone.DEFAULTS = {
		countries: [{"name":"Aruba","cca2":"AW","callingCode":"297"},{"name":"Afghanistan","cca2":"AF","callingCode":"93"},{"name":"Angola","cca2":"AO","callingCode":"244"},{"name":"Anguilla","cca2":"AI","callingCode":"1264"},{"name":"Åland Islands","cca2":"AX","callingCode":"358"},{"name":"Albania","cca2":"AL","callingCode":"355"},{"name":"Andorra","cca2":"AD","callingCode":"376"},{"name":"United Arab Emirates","cca2":"AE","callingCode":"971"},{"name":"Argentina","cca2":"AR","callingCode":"54"},{"name":"Armenia","cca2":"AM","callingCode":"374"},{"name":"American Samoa","cca2":"AS","callingCode":"1684"},{"name":"Antarctica","cca2":"AQ","callingCode":""},{"name":"French Southern and Antarctic Lands","cca2":"TF","callingCode":""},{"name":"Antigua and Barbuda","cca2":"AG","callingCode":"1268"},{"name":"Australia","cca2":"AU","callingCode":"61"},{"name":"Austria","cca2":"AT","callingCode":"43"},{"name":"Azerbaijan","cca2":"AZ","callingCode":"994"},{"name":"Burundi","cca2":"BI","callingCode":"257"},{"name":"Belgium","cca2":"BE","callingCode":"32"},{"name":"Benin","cca2":"BJ","callingCode":"229"},{"name":"Burkina Faso","cca2":"BF","callingCode":"226"},{"name":"Bangladesh","cca2":"BD","callingCode":"880"},{"name":"Bulgaria","cca2":"BG","callingCode":"359"},{"name":"Bahrain","cca2":"BH","callingCode":"973"},{"name":"Bahamas","cca2":"BS","callingCode":"1242"},{"name":"Bosnia and Herzegovina","cca2":"BA","callingCode":"387"},{"name":"Saint Barthélemy","cca2":"BL","callingCode":"590"},{"name":"Belarus","cca2":"BY","callingCode":"375"},{"name":"Belize","cca2":"BZ","callingCode":"501"},{"name":"Bermuda","cca2":"BM","callingCode":"1441"},{"name":"Bolivia","cca2":"BO","callingCode":"591"},{"name":"Brazil","cca2":"BR","callingCode":"55"},{"name":"Barbados","cca2":"BB","callingCode":"1246"},{"name":"Brunei","cca2":"BN","callingCode":"673"},{"name":"Bhutan","cca2":"BT","callingCode":"975"},{"name":"Bouvet Island","cca2":"BV","callingCode":""},{"name":"Botswana","cca2":"BW","callingCode":"267"},{"name":"Central African Republic","cca2":"CF","callingCode":"236"},{"name":"Canada","cca2":"CA","callingCode":"1"},{"name":"Cocos (Keeling) Islands","cca2":"CC","callingCode":"61"},{"name":"Switzerland","cca2":"CH","callingCode":"41"},{"name":"Chile","cca2":"CL","callingCode":"56"},{"name":"China","cca2":"CN","callingCode":"86"},{"name":"Ivory Coast","cca2":"CI","callingCode":"225"},{"name":"Cameroon","cca2":"CM","callingCode":"237"},{"name":"DR Congo","cca2":"CD","callingCode":"243"},{"name":"Republic of the Congo","cca2":"CG","callingCode":"242"},{"name":"Cook Islands","cca2":"CK","callingCode":"682"},{"name":"Colombia","cca2":"CO","callingCode":"57"},{"name":"Comoros","cca2":"KM","callingCode":"269"},{"name":"Cape Verde","cca2":"CV","callingCode":"238"},{"name":"Costa Rica","cca2":"CR","callingCode":"506"},{"name":"Cuba","cca2":"CU","callingCode":"53"},{"name":"Curaçao","cca2":"CW","callingCode":"5999"},{"name":"Christmas Island","cca2":"CX","callingCode":"61"},{"name":"Cayman Islands","cca2":"KY","callingCode":"1345"},{"name":"Cyprus","cca2":"CY","callingCode":"357"},{"name":"Czech Republic","cca2":"CZ","callingCode":"420"},{"name":"Germany","cca2":"DE","callingCode":"49"},{"name":"Djibouti","cca2":"DJ","callingCode":"253"},{"name":"Dominica","cca2":"DM","callingCode":"1767"},{"name":"Denmark","cca2":"DK","callingCode":"45"},{"name":"Dominican Republic","cca2":"DO","callingCode":"1809"},{"name":"Algeria","cca2":"DZ","callingCode":"213"},{"name":"Ecuador","cca2":"EC","callingCode":"593"},{"name":"Egypt","cca2":"EG","callingCode":"20"},{"name":"Eritrea","cca2":"ER","callingCode":"291"},{"name":"Western Sahara","cca2":"EH","callingCode":"212"},{"name":"Spain","cca2":"ES","callingCode":"34"},{"name":"Estonia","cca2":"EE","callingCode":"372"},{"name":"Ethiopia","cca2":"ET","callingCode":"251"},{"name":"Finland","cca2":"FI","callingCode":"358"},{"name":"Fiji","cca2":"FJ","callingCode":"679"},{"name":"Falkland Islands","cca2":"FK","callingCode":"500"},{"name":"France","cca2":"FR","callingCode":"33"},{"name":"Faroe Islands","cca2":"FO","callingCode":"298"},{"name":"Micronesia","cca2":"FM","callingCode":"691"},{"name":"Gabon","cca2":"GA","callingCode":"241"},{"name":"United Kingdom","cca2":"GB","callingCode":"44"},{"name":"Georgia","cca2":"GE","callingCode":"995"},{"name":"Guernsey","cca2":"GG","callingCode":"44"},{"name":"Ghana","cca2":"GH","callingCode":"233"},{"name":"Gibraltar","cca2":"GI","callingCode":"350"},{"name":"Guinea","cca2":"GN","callingCode":"224"},{"name":"Guadeloupe","cca2":"GP","callingCode":"590"},{"name":"Gambia","cca2":"GM","callingCode":"220"},{"name":"Guinea-Bissau","cca2":"GW","callingCode":"245"},{"name":"Equatorial Guinea","cca2":"GQ","callingCode":"240"},{"name":"Greece","cca2":"GR","callingCode":"30"},{"name":"Grenada","cca2":"GD","callingCode":"1473"},{"name":"Greenland","cca2":"GL","callingCode":"299"},{"name":"Guatemala","cca2":"GT","callingCode":"502"},{"name":"French Guiana","cca2":"GF","callingCode":"594"},{"name":"Guam","cca2":"GU","callingCode":"1671"},{"name":"Guyana","cca2":"GY","callingCode":"592"},{"name":"Hong Kong","cca2":"HK","callingCode":"852"},{"name":"Heard Island and McDonald Islands","cca2":"HM","callingCode":""},{"name":"Honduras","cca2":"HN","callingCode":"504"},{"name":"Croatia","cca2":"HR","callingCode":"385"},{"name":"Haiti","cca2":"HT","callingCode":"509"},{"name":"Hungary","cca2":"HU","callingCode":"36"},{"name":"Indonesia","cca2":"ID","callingCode":"62"},{"name":"Isle of Man","cca2":"IM","callingCode":"44"},{"name":"India","cca2":"IN","callingCode":"91"},{"name":"British Indian Ocean Territory","cca2":"IO","callingCode":"246"},{"name":"Ireland","cca2":"IE","callingCode":"353"},{"name":"Iran","cca2":"IR","callingCode":"98"},{"name":"Iraq","cca2":"IQ","callingCode":"964"},{"name":"Iceland","cca2":"IS","callingCode":"354"},{"name":"Israel","cca2":"IL","callingCode":"972"},{"name":"Italy","cca2":"IT","callingCode":"39"},{"name":"Jamaica","cca2":"JM","callingCode":"1876"},{"name":"Jersey","cca2":"JE","callingCode":"44"},{"name":"Jordan","cca2":"JO","callingCode":"962"},{"name":"Japan","cca2":"JP","callingCode":"81"},{"name":"Kazakhstan","cca2":"KZ","callingCode":"76"},{"name":"Kenya","cca2":"KE","callingCode":"254"},{"name":"Kyrgyzstan","cca2":"KG","callingCode":"996"},{"name":"Cambodia","cca2":"KH","callingCode":"855"},{"name":"Kiribati","cca2":"KI","callingCode":"686"},{"name":"Saint Kitts and Nevis","cca2":"KN","callingCode":"1869"},{"name":"South Korea","cca2":"KR","callingCode":"82"},{"name":"Kosovo","cca2":"XK","callingCode":"383"},{"name":"Kuwait","cca2":"KW","callingCode":"965"},{"name":"Laos","cca2":"LA","callingCode":"856"},{"name":"Lebanon","cca2":"LB","callingCode":"961"},{"name":"Liberia","cca2":"LR","callingCode":"231"},{"name":"Libya","cca2":"LY","callingCode":"218"},{"name":"Saint Lucia","cca2":"LC","callingCode":"1758"},{"name":"Liechtenstein","cca2":"LI","callingCode":"423"},{"name":"Sri Lanka","cca2":"LK","callingCode":"94"},{"name":"Lesotho","cca2":"LS","callingCode":"266"},{"name":"Lithuania","cca2":"LT","callingCode":"370"},{"name":"Luxembourg","cca2":"LU","callingCode":"352"},{"name":"Latvia","cca2":"LV","callingCode":"371"},{"name":"Macau","cca2":"MO","callingCode":"853"},{"name":"Saint Martin","cca2":"MF","callingCode":"590"},{"name":"Morocco","cca2":"MA","callingCode":"212"},{"name":"Monaco","cca2":"MC","callingCode":"377"},{"name":"Moldova","cca2":"MD","callingCode":"373"},{"name":"Madagascar","cca2":"MG","callingCode":"261"},{"name":"Maldives","cca2":"MV","callingCode":"960"},{"name":"Mexico","cca2":"MX","callingCode":"52"},{"name":"Marshall Islands","cca2":"MH","callingCode":"692"},{"name":"Macedonia","cca2":"MK","callingCode":"389"},{"name":"Mali","cca2":"ML","callingCode":"223"},{"name":"Malta","cca2":"MT","callingCode":"356"},{"name":"Myanmar","cca2":"MM","callingCode":"95"},{"name":"Montenegro","cca2":"ME","callingCode":"382"},{"name":"Mongolia","cca2":"MN","callingCode":"976"},{"name":"Northern Mariana Islands","cca2":"MP","callingCode":"1670"},{"name":"Mozambique","cca2":"MZ","callingCode":"258"},{"name":"Mauritania","cca2":"MR","callingCode":"222"},{"name":"Montserrat","cca2":"MS","callingCode":"1664"},{"name":"Martinique","cca2":"MQ","callingCode":"596"},{"name":"Mauritius","cca2":"MU","callingCode":"230"},{"name":"Malawi","cca2":"MW","callingCode":"265"},{"name":"Malaysia","cca2":"MY","callingCode":"60"},{"name":"Mayotte","cca2":"YT","callingCode":"262"},{"name":"Namibia","cca2":"NA","callingCode":"264"},{"name":"New Caledonia","cca2":"NC","callingCode":"687"},{"name":"Niger","cca2":"NE","callingCode":"227"},{"name":"Norfolk Island","cca2":"NF","callingCode":"672"},{"name":"Nigeria","cca2":"NG","callingCode":"234"},{"name":"Nicaragua","cca2":"NI","callingCode":"505"},{"name":"Niue","cca2":"NU","callingCode":"683"},{"name":"Netherlands","cca2":"NL","callingCode":"31"},{"name":"Norway","cca2":"NO","callingCode":"47"},{"name":"Nepal","cca2":"NP","callingCode":"977"},{"name":"Nauru","cca2":"NR","callingCode":"674"},{"name":"New Zealand","cca2":"NZ","callingCode":"64"},{"name":"Oman","cca2":"OM","callingCode":"968"},{"name":"Pakistan","cca2":"PK","callingCode":"92"},{"name":"Panama","cca2":"PA","callingCode":"507"},{"name":"Pitcairn Islands","cca2":"PN","callingCode":"64"},{"name":"Peru","cca2":"PE","callingCode":"51"},{"name":"Philippines","cca2":"PH","callingCode":"63"},{"name":"Palau","cca2":"PW","callingCode":"680"},{"name":"Papua New Guinea","cca2":"PG","callingCode":"675"},{"name":"Poland","cca2":"PL","callingCode":"48"},{"name":"Puerto Rico","cca2":"PR","callingCode":"1787"},{"name":"North Korea","cca2":"KP","callingCode":"850"},{"name":"Portugal","cca2":"PT","callingCode":"351"},{"name":"Paraguay","cca2":"PY","callingCode":"595"},{"name":"Palestine","cca2":"PS","callingCode":"970"},{"name":"French Polynesia","cca2":"PF","callingCode":"689"},{"name":"Qatar","cca2":"QA","callingCode":"974"},{"name":"Réunion","cca2":"RE","callingCode":"262"},{"name":"Romania","cca2":"RO","callingCode":"40"},{"name":"Russia","cca2":"RU","callingCode":"7"},{"name":"Rwanda","cca2":"RW","callingCode":"250"},{"name":"Saudi Arabia","cca2":"SA","callingCode":"966"},{"name":"Sudan","cca2":"SD","callingCode":"249"},{"name":"Senegal","cca2":"SN","callingCode":"221"},{"name":"Singapore","cca2":"SG","callingCode":"65"},{"name":"South Georgia","cca2":"GS","callingCode":"500"},{"name":"Svalbard and Jan Mayen","cca2":"SJ","callingCode":"4779"},{"name":"Solomon Islands","cca2":"SB","callingCode":"677"},{"name":"Sierra Leone","cca2":"SL","callingCode":"232"},{"name":"El Salvador","cca2":"SV","callingCode":"503"},{"name":"San Marino","cca2":"SM","callingCode":"378"},{"name":"Somalia","cca2":"SO","callingCode":"252"},{"name":"Saint Pierre and Miquelon","cca2":"PM","callingCode":"508"},{"name":"Serbia","cca2":"RS","callingCode":"381"},{"name":"South Sudan","cca2":"SS","callingCode":"211"},{"name":"São Tomé and Príncipe","cca2":"ST","callingCode":"239"},{"name":"Suriname","cca2":"SR","callingCode":"597"},{"name":"Slovakia","cca2":"SK","callingCode":"421"},{"name":"Slovenia","cca2":"SI","callingCode":"386"},{"name":"Sweden","cca2":"SE","callingCode":"46"},{"name":"Swaziland","cca2":"SZ","callingCode":"268"},{"name":"Sint Maarten","cca2":"SX","callingCode":"1721"},{"name":"Seychelles","cca2":"SC","callingCode":"248"},{"name":"Syria","cca2":"SY","callingCode":"963"},{"name":"Turks and Caicos Islands","cca2":"TC","callingCode":"1649"},{"name":"Chad","cca2":"TD","callingCode":"235"},{"name":"Togo","cca2":"TG","callingCode":"228"},{"name":"Thailand","cca2":"TH","callingCode":"66"},{"name":"Tajikistan","cca2":"TJ","callingCode":"992"},{"name":"Tokelau","cca2":"TK","callingCode":"690"},{"name":"Turkmenistan","cca2":"TM","callingCode":"993"},{"name":"Timor-Leste","cca2":"TL","callingCode":"670"},{"name":"Tonga","cca2":"TO","callingCode":"676"},{"name":"Trinidad and Tobago","cca2":"TT","callingCode":"1868"},{"name":"Tunisia","cca2":"TN","callingCode":"216"},{"name":"Turkey","cca2":"TR","callingCode":"90"},{"name":"Tuvalu","cca2":"TV","callingCode":"688"},{"name":"Taiwan","cca2":"TW","callingCode":"886"},{"name":"Tanzania","cca2":"TZ","callingCode":"255"},{"name":"Uganda","cca2":"UG","callingCode":"256"},{"name":"Ukraine","cca2":"UA","callingCode":"380"},{"name":"United States Minor Outlying Islands","cca2":"UM","callingCode":""},{"name":"Uruguay","cca2":"UY","callingCode":"598"},{"name":"United States","cca2":"US","callingCode":"1"},{"name":"Uzbekistan","cca2":"UZ","callingCode":"998"},{"name":"Vatican City","cca2":"VA","callingCode":"3906698"},{"name":"Saint Vincent and the Grenadines","cca2":"VC","callingCode":"1784"},{"name":"Venezuela","cca2":"VE","callingCode":"58"},{"name":"British Virgin Islands","cca2":"VG","callingCode":"1284"},{"name":"United States Virgin Islands","cca2":"VI","callingCode":"1340"},{"name":"Vietnam","cca2":"VN","callingCode":"84"},{"name":"Vanuatu","cca2":"VU","callingCode":"678"},{"name":"Wallis and Futuna","cca2":"WF","callingCode":"681"},{"name":"Samoa","cca2":"WS","callingCode":"685"},{"name":"Yemen","cca2":"YE","callingCode":"967"},{"name":"South Africa","cca2":"ZA","callingCode":"27"},{"name":"Zambia","cca2":"ZM","callingCode":"260"},{"name":"Zimbabwe","cca2":"ZW","callingCode":"263"}],
		error_message: {"INVALID_PH_N": "Invalid phone number","INVALID_CC": "Invalid country code","TOO_SHORT": "The phone number supplier is too short","TOO_LONG": "The phone number supplier is too long","UNKNOWN": "Unknow phone number"},
		item: '<li><a href="javascript:void(0)" role="button" class="country"><i style="margin-right: 10px;" id="@cca2" class="flag @cca2"></i>@name<i id="@callingCode" class="callingCode" style="margin-left: 10px;">+@callingCode</i></a><li>',
		intlInputPhone: '<input type="hidden" name="intlInputPhone" class="intlInputPhone" size="2" value=\'@data\' />',
		separator: '<li role="separator" class="divider"></li>',
		template: '<div class="input-group"><div class="input-group-btn dl"><button type="button" id="btn-country" class="dialbtn btn btn-default f16  dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="flag @cca2 btn-flag"></span><span class="btn-cc">&nbsp;&nbsp; +@callingCode &nbsp;&nbsp;</span><span class="caret"></span></button> <ul class="dropdown-menu f16">@country_items</ul></div><input type="text" name="phone" id="phoneNumber" class="form-control phoneNumber" placeholder="'+msg_phone_number+'" size="25" /><input type="hidden" name="defaultCountry" id="defaultCountry" size="2" value="@cca2" /><input type="hidden" name="carrierCode" id="carrierCode" size="2" value="@callingCode" /></div>'
	}

	IntlInputPhone.prototype.init = function() {
		this.render(IntlInputPhone.DEFAULTS.template, {
			cca2: this.getDefaultCountry().cca2.toLowerCase(),
			callingCode: this.getDefaultCountry().callingCode,
			country_items: this.countryItems()
		});
		this.btnEvent();
		this.inputEvent();
		this.formEvent()
	}

	IntlInputPhone.prototype.getDefaultCountry = function() {
		var dc, $this = this;
		$.each(IntlInputPhone.DEFAULTS.countries, function(index, value) { value.cca2 == $this.preferred_country[0].toUpperCase() ? dc = value : null });if (typeof dc == 'object') return dc;else throw new Error('Invalid default country.');
	}

	IntlInputPhone.prototype.countryItems = function() {
		var items = '', $this=this, pc = '', cs = '';
		$.each(IntlInputPhone.DEFAULTS.countries, function(index, value) {
			$.each($this.preferred_country, function(k, v) {
				if (v.toUpperCase() == value.cca2) {
					var c = $this.arrayToKeysValues(value).keys , d = $.map(value, function(vl, ix) { if (ix == 'cca2') return vl.toLowerCase(); else return vl; });
					pc += IntlInputPhone.DEFAULTS.item.format(c, d);
				}
			})
			var a = $this.arrayToKeysValues(value).keys , b = $.map(value, function(vl, ix) { if (ix == 'cca2') return vl.toLowerCase(); else return vl; });
			cs += IntlInputPhone.DEFAULTS.item.format(a, b);
		})
		if (pc.length > 0) { items += pc; items += IntlInputPhone.DEFAULTS.separator; } items += cs;
		return items;
	}

	IntlInputPhone.prototype.btnEvent = function() {
		var country = $('.country'), btn_flag = $('.btn-flag'), btn_cc = $('.btn-cc'), input_cca2 = $('#defaultCountry'), input_cc = $('#carrierCode');
		
		country.click(function() {
			var callingCode = $(this).find('.callingCode').attr('id'), flag = $(this).find('.flag').attr('id');
			btn_flag.attr('class', 'flag '+flag); btn_cc.html('&nbsp;&nbsp;+'+callingCode+'&nbsp;&nbsp;'); input_cca2.val(flag); input_cc.val(callingCode);
		})
	}

	IntlInputPhone.prototype.inputEvent = function() {
		var $this=this, h='';
		$('input.phoneNumber').on('blur', function() {
			$this.validate($(this));	
		})
	}

	IntlInputPhone.prototype.formEvent = function() {
		var form = this.element.closest('form'), $this=this;
		form.submit(function() {
			if ($this.validate($('input[name=phoneNumber]')) == false) {
				return false;
			}
		})
	}

	IntlInputPhone.prototype.validate = function(el) {
		var r = phoneNumberParser(), h='';
		if (typeof r == 'object') { this.hideError(el); h = IntlInputPhone.DEFAULTS.intlInputPhone.format(['data'], [JSON.stringify(r)]); if ($('.intlInputPhone').length > 0) { $('.intlInputPhone').remove(); $('.input-group').append(h); } else { $('.input-group').append(h); }
		} else { $('.intlInputPhone').remove(); this.showError(el, this.getErrorMessage(r));return false;}
	}

	IntlInputPhone.prototype.showError = function(el, message) {
		if (typeof this.display_error == 'string' && this.display_error == 'on') {
			el.attr('data-container', 'body'); el.attr('data-toggle', 'popover'); el.attr('data-placement', 'right'); el.attr('data-content', message); el.popover('show');
		} else if (typeof this.display_error == 'object') { this.display_error.text(message); } else { return ; }
	}

	IntlInputPhone.prototype.hideError = function(el) {
		if (typeof this.display_error == 'object') { this.display_error.remove(); }
		el.removeAttr('data-container'); el.removeAttr('data-toggle'); el.removeAttr('data-placement'); el.removeAttr('data-content'); el.popover('destroy');
	}

	IntlInputPhone.prototype.getErrorMessage = function(error_type) {
		var msg='', $this=this;
		switch(error_type) {
			case "INVALID_PH_N":msg=$this.error_message.INVALID_PH_N;break;
			case "INVALID_COUNTRY_CODE":msg=$this.error_message.INVALID_CC;break;
			case "TOO_SHORT":msg=$this.error_message.TOO_SHORT;break;
			case "TOO_LONG":msg=$this.error_message.TOO_LONG;break;
			case "UNKNOWN":msg=$this.error_message.UNKNOWN;break;
			default:msg=error_type;
		}
		return msg;
	}

	IntlInputPhone.prototype.render = function(template, data) {
		this.element.html(template.format(this.arrayToKeysValues(data).keys, this.arrayToKeysValues(data).values));
	}

	IntlInputPhone.prototype.arrayToKeysValues =  function(data) {
		if (typeof data == 'undefined') throw new Error('Can\'convert undefined object');
		else return  { keys: Object.keys(data), values: $.map(data, function(el) {return el}) }	
	}

	String.prototype.format = function(find, replace) {
		var replaceString = this, regex; 
		for (var i = 0; i < find.length; i++) {
		    regex = new RegExp('@'+find[i], "g");
		    replaceString = replaceString.replace(regex, replace[i]);
		}
		return replaceString;
	}

	function Plugin(options) {
		var inputPhone = new IntlInputPhone(this, options);
		inputPhone.init();
	}

	$.fn.intlInputPhone = Plugin
})(jQuery);