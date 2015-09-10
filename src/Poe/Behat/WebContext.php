<?php

namespace Poe\Behat;

use Behat\Mink\Exception\UnsupportedDriverActionException;

class WebContext extends DefaultContext
{
    /**
     * @Given /^I am on the (.+) (page)?$/
     * @When /^I go to the (.+) (page)?$/
     */
    public function iAmOnThePage($page)
    {
        $this->getSession()->visit($this->generateUrl($page));
    }

    /**
     * @Then /^I should be on the (.+) (page)$/
     * @Then /^I should be redirected to the (.+) (page)$/
     * @Then /^I should still be on the (.+) (page)$/
     */
    public function iShouldBeOnThePage($page)
    {
        $this->assertSession()->addressEquals($this->generateUrl($page));

        try {
            $this->assertStatusCodeEquals(200);
        } catch (UnsupportedDriverActionException $e) {
        }
    }

    /**
     * @When /^I click "([^"]+)"$/
     */
    public function iClick($link)
    {
        $this->clickLink($link);
    }

    /**
     * @Given I am logged in as :user
     */
    public function iAmLoggedInAsAuthorizationRole($user)
    {
        $this->loginWith($user, $user);
    }

    /**
     * @param string $login
     * @param string $password
     */
    private function loginWith($login, $password)
    {
        $this->getSession()->visit($this->generatePageUrl('fos_user_security_login'));

        $this->fillField('username', $login);
        $this->fillField('password', $password);
        $this->pressButton('_submit');
    }
}