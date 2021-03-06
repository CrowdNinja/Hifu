<?php
/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace SquareConnect\Api;

use \SquareConnect\Configuration;
use \SquareConnect\ApiClient;
use \SquareConnect\ApiException;
use \SquareConnect\ObjectSerializer;

/**
 * ReportingApiTest Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link     https://squareup.com/developers
 */
class ReportingApiTest extends \PHPUnit_Framework_TestCase
{
    private static $api;
    private static $test_accounts;
    private static $location_id;

    /**
     * Setup before running each test case
     */
    public static function setUpBeforeClass() {
        self::$api = new \SquareConnect\Api\ReportingApi();
        self::$test_accounts = new \SquareConnect\TestAccounts();
        // Configure OAuth2 access token for authorization: oauth2
        $account = self::$test_accounts->{'US-Prod'};
        $access_token = $account->access_token;
        Configuration::getDefaultConfiguration()->setAccessToken($access_token);

        self::$location_id = $account->location_id;
    }

    /**
     * Clean up after running each test case
     */
    public static function tearDownAfterClass() {

    }

    /**
     * Test case for listAdditionalRecipientReceivableRefunds
     *
     * ListAdditionalRecipientReceivableRefunds
     *
     */
    public function test_listAdditionalRecipientReceivableRefunds() {
    }
    /**
     * Test case for listAdditionalRecipientReceivables
     *
     * ListAdditionalRecipientReceivables
     *
     */
    public function test_listAdditionalRecipientReceivables() {
    }
}
