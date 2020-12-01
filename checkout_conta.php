<?php
	require_once('inc/def.php');
    require_once($siteHD.'inc/carrinho.php');

?>


                <div class="w100 cartMiniTable">
                    <table id="cart-summary" class="std table">
                        <tbody>
                        <tr>
                            <td>Total dos produtos</td>
                            <td class="price"><?php echo formata_real($carrinho->getSubTotal()); ?></td>
                        </tr>
												<?php if($_SERVER['REQUEST_URI']!="/checkout3"){ ?>
													<tr>
															<td> Total</td>
															<td class=" site-color" id="total-price"><?php echo formata_real($carrinho->getSubTotal()); ?></td>
													</tr>
												<?php }else{ ?>
                        <tr>
                            <td>Frete</td>
                            <td class="price"><?php echo formata_real($carrinho->getFrete()); ?></td>
                        </tr>
                        <tr>
                            <td> Total</td>
                            <td class=" site-color" id="total-price"><?php echo formata_real($carrinho->getSubTotal() + $carrinho->getFrete()); ?></td>
                        </tr>
                        

												<?php } ?>

                        <tr>
                            <td colspan="2">
                            <form method="POST" action="checkout1">
                                <div class="input-append couponForm">
                              
 <?php if(isset($_GET['cupom'])){?>
    <input class="col-lg-8" id="cupom" type="text" oninput="handleInput(event)" placeholder="<?php echo $_GET['cupom']?>"   value="<?php echo $_GET['cupom']?>"name="cupom"style="width:60%;">


 <?php }else { ?>
                                    <input class="col-lg-8" id="cupom" type="text" oninput="handleInput(event)" placeholder="Cupom"  name="cupom"style="width:60%;">
 <?php } ?>
                                    <button class="col-lg-4 btn btn-success" type="submit" style="width:38%; padding:8px 8px;">Aplicar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        </tbody>
                        <tbody>
                        </tbody>
                    </table>
                </div>
<script>

function handleInput(e) {
   var ss = e.target.selectionStart;
   var se = e.target.selectionEnd;
   e.target.value = e.target.value.toUpperCase();
   e.target.selectionStart = ss;
   e.target.selectionEnd = se;
}
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>