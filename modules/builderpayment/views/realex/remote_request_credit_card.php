<form role="form" action="/builderpayment/realexgateway/process_remote/<?=$order->id?>" method="post">
  <div class="form-group">
    <label for="exampleInputEmail1">Credit card number</label>
    <input type="text" class="form-control" name="credit_card_number" placeholder="Credit Card Number">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Name on card</label>
    <input type="text" class="form-control" name="credit_card_name" placeholder="">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">CVV (CSC/CVV/CVN)</label>
    <input type="text" class="form-control" name="credit_card_cvn" placeholder="Last digits on the back of your card">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Type</label>
    <select name="credit_card_type" class="form-control">
      <option value="">Please choose</option>
      <option value="visa">Visa</option>
      <option value="mc">MasterCard</option>
      <option value="laser">Laser</option>
      <option value="AMEX">American Express</option>
      <option value="DINERS">Diners</option>
    </select>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Expire date</label>
    <div class="form-control">
      <select name="credit_card_exp_month" class="form-control">
        <option value="01">01</option>
        <option value="02">02</option>
        <option value="03">03</option>
        <option value="04">04</option>
        <option value="05">05</option>
        <option value="06">06</option>
        <option value="07">07</option>
        <option value="08">08</option>
        <option value="09">09</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
      </select>
      <select name="credit_card_exp_year" class="form-control">
        <option value="14">14</option>
        <option value="15">15</option>
        <option value="16">16</option>
        <option value="17">17</option>
        <option value="18">18</option>
        <option value="19">19</option>
        <option value="20">20</option>
        <option value="21">21</option>
        <option value="22">22</option>
        <option value="23">23</option>
        <option value="24">24</option>
        <option value="25">25</option>
        <option value="26">26</option>
        <option value="27">27</option>
      </select>
    </div>
  </div>
  
  <button type="submit" class="btn btn-default">Pay Now</button>
</form>