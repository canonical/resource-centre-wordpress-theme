<div class="eight-col">

<style>
/* Your style here */
span.mktError span.mktFormMsg { position: relative; left: 68px !important; } 
</style></div></div>
<div id='lpeCDiv_6607' class='lpeCElement Form_1'><span class='lpContentsItem formSpan'>    <div id="socialSignOnHoldingPen" class="cf_widget cf_widget_socialsignon">

<script src="/js/mktFormSupport.js"></script>
    
<script>
  var formEdit = false;

  var socialSignOn = {
    isEnabled: false,
    enabledNetworks: [''],
    cfId: '',
    codeSnippet: ''
  };
</script>

<script>
var profiling = {
  isEnabled: true,
  numberOfProfilingFields: 2,
  alwaysShowFields: ['NewsletterOpt-In', 'Company', 'LastName', 'FirstName',  'mktDummyEntry']
};
var mktFormLanguage = 'English'
</script>
<script> function mktoGetForm() {return document.getElementById('mktForm_1079'); }</script>

<form class="lpeRegForm formNotEmpty" method="post" enctype="application/x-www-form-urlencoded" action="https://pages.canonical.com/index.php/leadCapture/save" id="mktForm_1079" name="mktForm_1079">
    
    <ul class='mktLblLeft'>
        <li class='mktField' style="display: none;">
            <label>utm_campaign:</label>
            <span class='mktInput'>
                <input class='mktFormHidden' name="utm_campaign" id="utm_campaign" type='hidden' value="" />
                <span class='mktFormMsg'></span>
            </span>
        </li>
        <li class='mktField' style="display: none;">
            <label>utm_medium:</label>
            <span class='mktInput'>
                <input class='mktFormHidden' name="utm_medium" id="utm_medium" type='hidden' value="blank" />
                <span class='mktFormMsg'></span>
            </span>
        </li>
        <li class='mktField' style="display: none;">
            <label>utm_source:</label>
            <span class='mktInput'>
                <input class='mktFormHidden' name="utm_source" id="utm_source" type='hidden' value="Blank" />
                <span class='mktFormMsg'></span>
            </span>
        </li>
        <li class='mktFormReq mktField'>
            <label>First name:</label>
            <span class='mktInput'>
                <input class='mktFormText mktFormString mktFReq' name="FirstName" id="FirstName" type='text' value=""  maxlength='255' tabIndex='4' />
                <span class='mktFormMsg'></span>
            </span>
        </li>
        <li class='mktFormReq mktField'>
            <label>Last name:</label>
            <span class='mktInput'>
                <input class='mktFormText mktFormString mktFReq' name="LastName" id="LastName" type='text' value=""  maxlength='255' tabIndex='5' />
                <span class='mktFormMsg'></span>
            </span>
        </li>
        <li class='mktFormReq mktField'>
            <label>Company name:</label>
            <span class='mktInput'>
                <input class='mktFormText mktFormString mktFReq' name="Company" id="Company" type='text' value=""  maxlength='255' tabIndex='6' />
                <span class='mktFormMsg'></span>
            </span>
        </li>
        <li class='mktFormReq mktField'>
            <label>Job Role:</label>
            <span class='mktInput'>
                <select class='mktFormSelect mktFReq' name="Job_Role__c" id="Job_Role__c" size='1'   tabIndex='7'>
                    <option value='Please select' selected='selected'>Please select</option>
                    <option value='Business and Project Management'>Business and Project Management</option>
                    <option value='Database Development and Administration'>Database Development and Administration</option>
                    <option value='Education'>Education</option>
                    <option value='Enterprise Systems Analysis &amp; Integration'>Enterprise Systems Analysis &amp; Integration</option>
                    <option value='Hardware Operations and Management'>Hardware Operations and Management</option><option value='Home User'>Home User</option>
                    <option value='Individual'>Individual</option>
                    <option value='Network Design and Administration'>Network Design and Administration</option>
                    <option value='Owner/Self Employed'>Owner/Self Employed</option>
                    <option value='Press and Communications'>Press and Communications</option>
                    <option value='Programming/Software Engineering'>Programming/Software Engineering</option><option value='Smartphone User'>Smartphone User</option>
                    <option value='Technical Support'>Technical Support</option>
                    <option value='Technical Writing'>Technical Writing</option>
                    <option value='Ubuntu Enthusiast'>Ubuntu Enthusiast</option>
                    <option value='Web Development and Administration'>Web Development and Administration</option>
                </select>
                <span class='mktFormMsg'></span>
            </span>
        </li>
        <li class='mktFormReq mktField'>
            <label>Email Address:</label>
            <span class='mktInput'>
                <input class='mktFormText mktFormEmail mktFReq' name="Email" id="Email" type='text' value=""  maxlength='255' tabIndex='8' />
                <span class='mktFormMsg'></span>
            </span>
        </li>
        <li class='mktField'>
            <label>Currently Using Ubuntu:</label>
            <span class='mktInput'>
                <input class='mktFormText mktFormPicklist' name="CurrentlyUsingUbuntu" id="CurrentlyUsingUbuntu" type='text' value=""  maxlength='255' tabIndex='9' />
                <span class='mktFormMsg'></span>
            </span>
        </li>
        <li class='mktField'>
            <label>Number of Employees:</label>
            <span class='mktInput'>
                <select class='mktFormSelect' name="num_employees__c" id="num_employees__c" size='1'   tabIndex='10'>
                    <option value='None' selected='selected'>None</option>
                    <option value='&lt;500'>&lt;500</option>
                    <option value='501-1000'>501-1000</option>
                    <option value='1001-2000'>1001-2000</option>
                    <option value='2001-5000'>2001-5000</option>
                    <option value='5000+'>5000+</option>
                </select>
                <span class='mktFormMsg'></span>
            </span>
        </li>
        <li class='mktField mktLblRight'>
            <span class='mktInput mktLblRight'>
                <input class='mktFormCheckbox' name="NewsletterOpt-In" id="NewsletterOpt-In" type='checkbox' value="1"   tabIndex='11' />
                <label>I would like to receive occasional news from Canonical by email.                                         </label>&nbsp;
                <span class='mktFormMsg'></span>
            </span>
        </li>
        <li id='mktFrmButtons'>
            <input id='mktFrmSubmit' type='submit' value='Submit' name='submitButton' onclick='formSubmit(document.getElementById("mktForm_1079")); return false;' />&nbsp;
            <input style='display: none;' id='mktFrmReset' type='reset' value='Clear' name='resetButton' onclick='formReset(document.getElementById("mktForm_1079")); return false;' />
        </li>
    </ul>
  
  <span style="display:none;"><input type="text" name="_marketo_comments" value="" /></span>
  <input type="hidden" name="lpId" value="1214" />
  <input type="hidden" name="subId" value="30" />
  <input type="hidden" name="munchkinId" value="066-EOV-335" />
  <input type="hidden" name="kw" value="" />
  <input type="hidden" name="cr" value="" />
  <input type="hidden" name="searchstr" value="" />
  <input type="hidden" name="lpurl" value="https://pages.canonical.com/confirmed-download-cloud.html?cr={creative}&kw={keyword}" />
  <input type="hidden" name="formid" value="1079" />
  <input type="hidden" name="returnURL" value="<?php the_permalink() ?>?<?php echo $postdate . $postid; ?>" />
  <input type="hidden" name="retURL" value="<?php the_permalink() ?>?<?php echo $postdate . $postid; ?>" />
  <input type="hidden" name="returnLPId" value="-1" />
  <input type="hidden" name="_mkt_disp" value="return" />
  <input type="hidden" name="_mkt_trk" value="id:066-EOV-335" />
</form>

<script src="/js/mktFormSupport.js"></script>

<script>
    function formSubmit(elt) {
        return Mkto.formSubmit(elt);
    }
    function formReset(elt) {
        return Mkto.formReset(elt);
    }
</script>

</div>