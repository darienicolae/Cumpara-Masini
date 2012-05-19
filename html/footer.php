<div class="clear"></div>

</div>

</div>
<div id="footer">
<div id="footercontent">
<div id="copyright">&copy; Cumpara Masini | <a href="index.php">Home </a></div>
</div>

</div>
<script type="text/javascript">
$("#camp_marca").change(function(){
        $("#camp_model").load("http://173.203.100.21/cumparamasini/getmodels.php?id=" + $("#camp_marca").find(":selected").val());
});
</script>
</body>
</html>