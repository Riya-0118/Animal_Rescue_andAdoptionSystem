<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Page</title>
</head>
<body>
        <h1>Donation Page</h1>
        <p>Thank you for your interest in donating!</p>
        <form action="donation.php" method="POST">
        <div class="amount-options">
    <button type="button" class="amount-btn active" data-amount="500">
        Rs. 500
    </button>

    <button type="button" class="amount-btn" data-amount="1000">
        Rs. 1,000
    </button>

    <button type="button" class="amount-btn" data-amount="2000">
        Rs. 2,000
    </button>

    <button type="button" class="amount-btn" data-amount="3000">
        Rs. 3,000
    </button>

    <button type="button" class="amount-btn" data-amount="5000">
        Rs. 5,000
    </button>

    <button type="button" class="amount-btn" data-amount="10000">
        Rs. 10,000
    </button>
</div>

<label for="customAmount" class="custom-label">
    Or Enter Custom Amount (NPR)
</label>

<input
    type="number"
    id="customAmount"
    name="customAmount"
    class="custom-amount"
    placeholder="Enter your amount"
    min="1"
    step="1"
>

<input type="hidden" name="amount" id="selectedAmount" value="500">

<button type="submit" class="donate-btn">Donate Now</button>
        </form>
</body>
</html>