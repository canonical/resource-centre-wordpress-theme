<div class="four-col box box-highlight box-digest">

<form action="https://pages.canonical.com/index.php/leadCapture/save" method="post" id="mktoForm_1212">
  <h2>Sign up for email updates</h2>
  <p>Choose the topics you're interested in</p>
    <?php
      $term_list = wp_get_post_terms($post->ID, 'group', array("fields" => "slugs"));
      $termsString = $term_list;
      $current_tax = basename(get_permalink());
      $cs = 'cloud-and-server';
      $desktop = 'desktop';
      $iot = 'internet-of-things';
    ?>

    <ul class="no-bullets">
      <li>
        <ul class="no-bullets">
          <li>
            <input class="mktoLogicalField mktoCheckboxList mktoHasWidth" type="checkbox" id="insightscloudserver" name="insightscloudserver" value="yes"<?php if(in_array($cs, $termsString) or $current_tax == $cs or is_home() or is_page_template( 'page-press.php' )) echo ' checked="checked" ' ?>/>
            <label for="insightscloudserver">Cloud and server</label>
          </li>
          <li>
            <input class="mktoLogicalField mktoCheckboxList mktoHasWidth" type="checkbox" id="insightsdesktop" name="insightsdesktop" value="yes"<?php if(in_array($desktop, $termsString) or $current_tax == $desktop or is_home() or is_page_template( 'page-press.php' )) echo ' checked="checked" ' ?>/>
            <label for="insightsdesktop">Desktop</label>
          </li>
          <li>
            <input class="mktoLogicalField mktoCheckboxList mktoHasWidth" type="checkbox" id="insightsiot" name="insightsiot" value="yes"<?php if(in_array('internet-of-things', $termsString) or $current_tax == 'internet-of-things' or is_home() or is_page_template( 'page-press.php' )) echo ' checked="checked" ' ?>/>
            <label for="insightsiot">Internet of Things</label>
          </li>
          <li>
            <input class="mktoLogicalField mktoCheckboxList mktoHasWidth" type="checkbox" id="insightstutorials" name="insightstutorials" value="yes" checked="checked" />
            <label for="insightstutorials">Tutorials</label>
          </li>
        </ul>
      </li>
      <li  class="mktFormReq mktField">
        <label for="Email" class="mktoLabel">Work email: <span>*</span></label>
        <input required  id="Email" name="Email" maxlength="255" type="email" class="mktoField mktoEmailField  mktoRequired" >
      </li>
      <li class="mktField mktLblRight">
        <span class="mktInput mktLblRight"><input class="mktFormCheckbox" name="canonicalUpdatesOptIn" id="canonicalUpdatesOptIn" value="yes" tabindex="9" type="checkbox" /><label>I would like to receive occasional updates from Canonical by email.</label>&nbsp;<span class="mktFormMsg"></span></span>
      </li>
      <li  class="mktField">
        <span class='mktoButtonWrap'><button type='submit' class='mktoButton'>Subscribe now</button></span>

        <input value="1959" class="mktoField mktoFieldDescriptor" name="lpId" type="hidden">
        <input value="30" class="mktoField mktoFieldDescriptor" name="subId" type="hidden">
        <input type="hidden" name="lpurl" value="https://pages.canonical.com/Insights-Subscription_Insights-Subscription-test.html?cr={creative}&amp;kw={keyword}" />
        <input value="1212" class="mktoField mktoFieldDescriptor" name="formid" type="hidden">
        <input type="hidden" name="ret" value="<?php $theurl = rtrim(get_permalink(),'/'); echo $theurl; ?>?digest=true" />
        <input value="066-EOV-335" class="mktoField mktoFieldDescriptor" name="munchkinId" type="hidden">
        <input type="hidden" name="kw" value=""/>
        <input type="hidden" name="cr" value=""/>
        <input type="hidden" name="searchstr" value=""/>
        <input type="hidden" name="_mkt_disp" value="return"/>
        <input type="hidden" name="_mkt_trk" value=""/>
      </li>
    </ul>
</form>
</div>

<script src="https://assets.ubuntu.com/v1/5d7e5bbf-jquery-2.2.0.min.js"></script>
<script src="https://assets.ubuntu.com/v1/d55f58bb-jquery.validate.js"></script>

<script>
$("#mktoForm_1212").validate({
    errorElement: "span",
    errorClass: "mktFormMsg mktError"
});
</script>
