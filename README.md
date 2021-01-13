# stripe-ckeckout-symfony

Installation
------------

```bash
$ composer require stripe/stripe-php

$ composer require doctrine/annotations
```

Stripe 
------------

1) Ajouter la librairie Stripe.js dans votre page (ex: base.html.twig).

html`

<head>
    <script src="https://js.stripe.com/v3/"></script>
</head>

`

2) Ajouter le bouton qui va rediriger et lancer la session Stripe checkout pour facturer le client.

html`
<body>
    <button id="checkout-button">Checkout</button>
    ```js
    <script type="text/javascript">
      // Create an instance of the Stripe object with your publishable API key
      var stripe = Stripe('pk_test_51I7qCgIjktDIYiezyk245q27khXTpXCzXgu9AMx3A6n1ay8U81Ap7Rt8EpMUwu9kk9qWC2QC5Ymi0MJ9eJahAiBR00gqYitQ6F');
      var checkoutButton = document.getElementById('checkout-button');
      checkoutButton.addEventListener('click', function() {
        // Create a new Checkout Session using the server-side endpoint you
        // created in step 3.
        fetch('/create-checkout-session', {
          method: 'POST',
        })
        .then(function(response) {
          return response.json();
        })
        .then(function(session) {
          return stripe.redirectToCheckout({ sessionId: session.id });
        })
        .then(function(result) {
          // If `redirectToCheckout` fails due to a browser or network
          // error, you should display the localized error message to your
          // customer using `error.message`.
          if (result.error) {
            alert(result.error.message);
          }
        })
        .catch(function(error) {
          console.error('Error:', error);
        });
      });
    </script>
  </body>
`

Usage
------------

1) Ajouter le dossier "Checkout" dans le dossier "Src" de votre application Symfony.
2) Ajouter le bouton qui va permettre de créer la session et rediriger le client sur la page de Stripe checkout.
3) Ajouter le clés Api. La secrete dans le fichier "StripeCheckout.php" et la publique dans le script de la page ou vous souhaitez faire apparaitre le bouton.

Remarque
------------

Vous pouvez utiliser la methode de la classe "StripeCheckout.php" comme un service via l'injection de dépendances
ou simplement appeler la route qui retourne la session Stripe (route appelée par le bouton placé dans votre vue).