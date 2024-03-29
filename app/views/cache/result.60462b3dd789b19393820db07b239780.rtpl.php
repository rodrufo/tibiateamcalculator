<?php if(!class_exists('Rain\Tpl')){exit;}?><section id="container"></section>


<div class="calculator-result">
    <h1>Resultado:</h1>
    
   <div class="calculator-balance">

    <?php if( $sessiondata["totalbalance"] > 0 ){ ?>
         <h3>O lucro total foi de <span class="profit"><?php echo number_format($sessiondata["totalbalance"]); ?> </span> e o individual de <span class="profit"><?php echo number_format($sessiondata["individualBalance"]); ?></span></h3><br>

    <?php }else{ ?>
         O prejuízo total foi de <span class="waste"> <?php echo number_format($sessiondata["totalbalance"]); ?>  </span> e o individual de <span class="waste"><?php echo number_format($sessiondata["individualBalance"]); ?></span>
    <?php } ?>       

   </div> <br>

   <div class="calculator-payments">

    <ul>
        <h3>Os seguintes pagamentos devem ser feitos: </h3><br>
        <?php $counter1=-1;  if( isset($sessiondata["payments"]) && ( is_array($sessiondata["payments"]) || $sessiondata["payments"] instanceof Traversable ) && sizeof($sessiondata["payments"]) ) foreach( $sessiondata["payments"] as $key1 => $value1 ){ $counter1++; ?>

            <li class="whoandhowmuch"> <span class="payer"><?php echo htmlspecialchars( $value1["payer"], ENT_COMPAT, 'UTF-8', FALSE ); ?></span> deve pagar <span class="howmuch-to-pay"><?php echo htmlspecialchars( $value1["value"], ENT_COMPAT, 'UTF-8', FALSE ); ?></span> para <span class="receiver"><?php echo htmlspecialchars( $value1["receiver"], ENT_COMPAT, 'UTF-8', FALSE ); ?></span>  ( transfer <?php echo htmlspecialchars( $value1["value"], ENT_COMPAT, 'UTF-8', FALSE ); ?> to <?php echo htmlspecialchars( $value1["receiver"], ENT_COMPAT, 'UTF-8', FALSE ); ?> )</li>            
            
        <?php } ?>
    </ul>

   </div><br>

   <h2>Lista dos TOP</h2>
   <div class="topdata">

    

        <div class="top toploot">
            <h3>Quem pegou mais loot</h3>
            <?php $counter1=-1;  if( isset($toploot) && ( is_array($toploot) || $toploot instanceof Traversable ) && sizeof($toploot) ) foreach( $toploot as $key1 => $value1 ){ $counter1++; ?>

            <li><?php echo htmlspecialchars( $value1["name"], ENT_COMPAT, 'UTF-8', FALSE ); ?>: <?php if( $value1["loot"] <= 0 ){ ?> <span class="waste"><?php echo htmlspecialchars( $value1["loot"], ENT_COMPAT, 'UTF-8', FALSE ); ?></span> <?php }else{ ?><span class="profit"><?php echo htmlspecialchars( $value1["loot"], ENT_COMPAT, 'UTF-8', FALSE ); ?> <?php } ?> </li>    

            <?php } ?>

        </div>

        <div class="top topsupplies">
            <h3>Quem gastou mais:</h3>
            <?php $counter1=-1;  if( isset($topsupplies) && ( is_array($topsupplies) || $topsupplies instanceof Traversable ) && sizeof($topsupplies) ) foreach( $topsupplies as $key1 => $value1 ){ $counter1++; ?>

            <li><?php echo htmlspecialchars( $value1["name"], ENT_COMPAT, 'UTF-8', FALSE ); ?>:  <?php echo htmlspecialchars( $value1["supplies"], ENT_COMPAT, 'UTF-8', FALSE ); ?> </li>    

            <?php } ?>

        </div>

        <div class="top topbalance">
            <h3>Quem tem o melhor balance:</h3>
            <?php $counter1=-1;  if( isset($topbalance) && ( is_array($topbalance) || $topbalance instanceof Traversable ) && sizeof($topbalance) ) foreach( $topbalance as $key1 => $value1 ){ $counter1++; ?>

            <li><?php echo htmlspecialchars( $value1["name"], ENT_COMPAT, 'UTF-8', FALSE ); ?>:  <?php if( $value1["balance"] <= 0 ){ ?> <span class="waste"><?php echo htmlspecialchars( $value1["balance"], ENT_COMPAT, 'UTF-8', FALSE ); ?></span> <?php }else{ ?><span class="profit"><?php echo htmlspecialchars( $value1["balance"], ENT_COMPAT, 'UTF-8', FALSE ); ?> <?php } ?> </li>    

            <?php } ?>

        </div>

        <div class="top topdamage">
            <h3>Quem deu mais dano:</h3>

            <?php $counter1=-1;  if( isset($topdamage) && ( is_array($topdamage) || $topdamage instanceof Traversable ) && sizeof($topdamage) ) foreach( $topdamage as $key1 => $value1 ){ $counter1++; ?>

            <li><?php echo htmlspecialchars( $value1["name"], ENT_COMPAT, 'UTF-8', FALSE ); ?>: <?php echo htmlspecialchars( $value1["damage"], ENT_COMPAT, 'UTF-8', FALSE ); ?> </li>    

            <?php } ?>

        </div>


        <div class=" top tophealing">
            <h3>Quem curou mais:</h3>

            <?php $counter1=-1;  if( isset($tophealing) && ( is_array($tophealing) || $tophealing instanceof Traversable ) && sizeof($tophealing) ) foreach( $tophealing as $key1 => $value1 ){ $counter1++; ?>

            <li><?php echo htmlspecialchars( $value1["name"], ENT_COMPAT, 'UTF-8', FALSE ); ?>: <?php echo htmlspecialchars( $value1["healing"], ENT_COMPAT, 'UTF-8', FALSE ); ?> </li>    

            <?php } ?>

        </div>   
        
       
    


   </div>

   

</div>


</section>