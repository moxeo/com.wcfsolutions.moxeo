<fieldset>
	<legend>{lang}wsis.acp.theme.module.navigation.data{/lang}</legend>
	
	<div class="formElement" id="levelOffsetDiv">
		<div class="formFieldLabel">
			<label for="levelOffset">{lang}wsis.acp.theme.module.navigation.levelOffset{/lang}</label>
		</div>
		<div class="formField">
			<input type="text" class="inputText" id="levelOffset" name="levelOffset" value="{@$levelOffset}" />
		</div>
		<div class="formFieldDesc hidden" id="levelOffsetHelpMessage">
			<p>{lang}wsis.acp.theme.module.navigation.levelOffset.description{/lang}</p>
		</div>
	</div>
	<script type="text/javascript">//<![CDATA[
		inlineHelp.register('levelOffset');
	//]]></script>
	
	<div class="formElement" id="levelLimitDiv">
		<div class="formFieldLabel">
			<label for="levelLimit">{lang}wsis.acp.theme.module.navigation.levelLimit{/lang}</label>
		</div>
		<div class="formField">
			<input type="text" class="inputText" id="levelLimit" name="levelLimit" value="{@$levelLimit}" />
		</div>
		<div class="formFieldDesc hidden" id="levelLimitHelpMessage">
			<p>{lang}wsis.acp.theme.module.navigation.levelLimit.description{/lang}</p>
		</div>
	</div>
	<script type="text/javascript">//<![CDATA[
		inlineHelp.register('levelLimit');
	//]]></script>
</fieldset>