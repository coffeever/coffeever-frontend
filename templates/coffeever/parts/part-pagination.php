<?php
defined('INDEX') or die();

$page = getPage();
$pageMax = isset($pageMax) ? $pageMax : 1;
if($pageMax<2){
    return;
}
$printablePages = [];
//toplam 7 tane hakkın var

if($pageMax < 8){
    for($i=1;$i<=$pageMax;$i++){
        $printablePages[] = $i;
    }
}
elseif($pageMax>= 8){
    //$printablePages[] = 1;
    if($page<=5){
        for($i=1;$i<=6;$i++){
            $printablePages[] = $i;
        }
        $printablePages[] = -1;
        $printablePages[] = $pageMax;
    }
    else if ($page+5>$pageMax){
        $printablePages[] = 1;
        $printablePages[] = -1;
        for($i=$pageMax-5;$i<=$pageMax;$i++){
            $printablePages[] = $i;
        }
    }
    else{
        $printablePages[] = 1;
        $printablePages[] = -1;
        for($i=$page-2;$i<=$page+2;$i++){
            $printablePages[] = $i;
        }
        $printablePages[] = -1;
        $printablePages[] = $pageMax;
    }
}
$pathurl=strtok($_SERVER["REQUEST_URI"],'?');
$urlprefix = str_replace(SITE_URL.'/','',$pathurl);

?>
<div class="row mt-5">
    <div class="col text-center">
      <div class="block-27">
        <ul>
            <?php if($page>1): ?>
                <li><a href="<?php echo $urlprefix.addParamsToQueryString('page',$page-1)?>">&lt;</a></li>
            <?php endif ?>
            <?php foreach($printablePages as $pp ): ?>
                <?php if($pp==-1): ?>
                    <li><a>...</a></li>
                <?php else: ?>
                    <?php if($pp==$page): ?>
                        <li><span class="active"><?php echo $pp;?></span></li>
                    <?php else: ?>
                        <li><a href="<?php echo $urlprefix.addParamsToQueryString('page',$pp)?>"><?php echo $pp;?></a></li>
                    <?php endif ?>
                <?php endif; ?>
            <?php endforeach; ?>

            <?php if($page<$pageMax): ?>
                <li><a href="<?php echo $urlprefix.addParamsToQueryString('page',$page+1)?>">&gt;</a></li>
            <?php endif ?>
        </ul>
      </div>
    </div>
</div>