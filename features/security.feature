# This file contains a user story for demonstration only.
# Learn how to get started with Behat and BDD on Behat's website:
# http://behat.org/en/latest/quick_start.html

Feature:
    In order to montrer qu'on peut se créer un compte
    As un nouvel utilisateur
    I want to créer un compte

    Scenario: On peut aller sur la page de login depuis la home
        Given on se trouve sur la page "/"
        When Je clique sur le bouton "Se créer un compte"
        Then Je suis alors sur la page "/register"
