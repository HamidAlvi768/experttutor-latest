<?php



namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $country
 * @property int $coin_value
 * @property int $member_coin_value

 * @property string $created_at
 * @property string $updated_at
 */
class ApplyCoin extends ActiveRecord
{
    public static function tableName()
    {
        return 'apply_coins'; // DB table name
    }

    public function rules()
    {
        return [
            [['coin_value'], 'required'],
            ['member_coin_value', 'required'],
            ['country', 'required',  'message' => 'Region is required'], // for multiple select
            ['coin_value', 'integer', 'min' => 1],
        ];
    }

    public function attributeLabels()
    {
        return [
            'country' => 'Region',
            'coin_value' => 'Apply Coin',
            'member_coin_value' => 'MemberShip Coins'
        ];
    }


    public function getContinentFromLocation($location)
    {
        // Validate input
        if (empty(trim($location))) {
            return ['error' => 'Location cannot be empty'];
        }

        // Extract country from location (usually at the end)
        $country = $this->extractCountryFromLocation($location);

        if (!$country) {
            return ['error' => 'Could not identify country from location'];
        }

        // Get continent from country
        $continent = $this->getContinentFromCountry($country);

        if ($continent === 'Unknown') {
            return ['error' => 'Could not determine continent for country: ' . $country];
        }

        return [
            'location' => $location,
            'country' => $country,
            'continent' => $continent,
            'source' => 'Manual mapping'
        ];
    }

    public function extractCountryFromLocation($location)
    {
        // Remove any extra spaces and commas
        $location = trim($location);

        // Split by commas and get the last part (usually the country)
        $parts = array_map('trim', explode(',', $location));

        if (count($parts) > 0) {
            $possibleCountry = end($parts);

            // Handle common country variations and abbreviations
            $countryVariations = [
                'USA' => 'United States',
                'US' => 'United States',
                'U.S.' => 'United States',
                'U.S.A.' => 'United States',
                'UK' => 'United Kingdom',
                'U.K.' => 'United Kingdom',
                'GB' => 'United Kingdom',
                'Great Britain' => 'United Kingdom',
            ];

            // Check if it's a known variation
            if (isset($countryVariations[$possibleCountry])) {
                return $countryVariations[$possibleCountry];
            }

            return $possibleCountry;
        }

        return $location;
    }

    public function getContinentFromCountry($country)
    {
        $continentMapping = [
            // Africa
            'Algeria' => 'Africa',
            'Angola' => 'Africa',
            'Benin' => 'Africa',
            'Botswana' => 'Africa',
            'Burkina Faso' => 'Africa',
            'Burundi' => 'Africa',
            'Cabo Verde' => 'Africa',
            'Cameroon' => 'Africa',
            'Central African Republic' => 'Africa',
            'Chad' => 'Africa',
            'Comoros' => 'Africa',
            'Congo' => 'Africa',
            'DR Congo' => 'Africa',
            'Democratic Republic of the Congo' => 'Africa',
            'Djibouti' => 'Africa',
            'Egypt' => 'Africa',
            'Equatorial Guinea' => 'Africa',
            'Eritrea' => 'Africa',
            'Eswatini' => 'Africa',
            'Ethiopia' => 'Africa',
            'Gabon' => 'Africa',
            'Gambia' => 'Africa',
            'Ghana' => 'Africa',
            'Guinea' => 'Africa',
            'Guinea-Bissau' => 'Africa',
            'Ivory Coast' => 'Africa',
            'Kenya' => 'Africa',
            'Lesotho' => 'Africa',
            'Liberia' => 'Africa',
            'Libya' => 'Africa',
            'Madagascar' => 'Africa',
            'Malawi' => 'Africa',
            'Mali' => 'Africa',
            'Mauritania' => 'Africa',
            'Mauritius' => 'Africa',
            'Morocco' => 'Africa',
            'Mozambique' => 'Africa',
            'Namibia' => 'Africa',
            'Niger' => 'Africa',
            'Nigeria' => 'Africa',
            'Rwanda' => 'Africa',
            'Sao Tome and Principe' => 'Africa',
            'Senegal' => 'Africa',
            'Seychelles' => 'Africa',
            'Sierra Leone' => 'Africa',
            'Somalia' => 'Africa',
            'South Africa' => 'Africa',
            'South Sudan' => 'Africa',
            'Sudan' => 'Africa',
            'Tanzania' => 'Africa',
            'Togo' => 'Africa',
            'Tunisia' => 'Africa',
            'Uganda' => 'Africa',
            'Zambia' => 'Africa',
            'Zimbabwe' => 'Africa',

            // Asia
            'Afghanistan' => 'Asia',
            'Armenia' => 'Asia',
            'Azerbaijan' => 'Asia',
            'Bahrain' => 'Asia',
            'Bangladesh' => 'Asia',
            'Bhutan' => 'Asia',
            'Brunei' => 'Asia',
            'Cambodia' => 'Asia',
            'China' => 'Asia',
            'Cyprus' => 'Asia',
            'Georgia' => 'Asia',
            'India' => 'Asia',
            'Indonesia' => 'Asia',
            'Iran' => 'Asia',
            'Iraq' => 'Asia',
            'Israel' => 'Asia',
            'Japan' => 'Asia',
            'Jordan' => 'Asia',
            'Kazakhstan' => 'Asia',
            'Kuwait' => 'Asia',
            'Kyrgyzstan' => 'Asia',
            'Laos' => 'Asia',
            'Lebanon' => 'Asia',
            'Malaysia' => 'Asia',
            'Maldives' => 'Asia',
            'Mongolia' => 'Asia',
            'Myanmar' => 'Asia',
            'Nepal' => 'Asia',
            'North Korea' => 'Asia',
            'Oman' => 'Asia',
            'Pakistan' => 'Asia',
            'Palestine' => 'Asia',
            'Philippines' => 'Asia',
            'Qatar' => 'Asia',
            'Russia' => 'Asia',
            'Saudi Arabia' => 'Asia',
            'Singapore' => 'Asia',
            'South Korea' => 'Asia',
            'Sri Lanka' => 'Asia',
            'Syria' => 'Asia',
            'Taiwan' => 'Asia',
            'Tajikistan' => 'Asia',
            'Thailand' => 'Asia',
            'Timor-Leste' => 'Asia',
            'Turkey' => 'Asia',
            'Turkmenistan' => 'Asia',
            'United Arab Emirates' => 'Asia',
            'Uzbekistan' => 'Asia',
            'Vietnam' => 'Asia',
            'Yemen' => 'Asia',

            // Europe
            'Albania' => 'Europe',
            'Andorra' => 'Europe',
            'Austria' => 'Europe',
            'Belarus' => 'Europe',
            'Belgium' => 'Europe',
            'Bosnia and Herzegovina' => 'Europe',
            'Bulgaria' => 'Europe',
            'Croatia' => 'Europe',
            'Czech Republic' => 'Europe',
            'Denmark' => 'Europe',
            'Estonia' => 'Europe',
            'Finland' => 'Europe',
            'France' => 'Europe',
            'Germany' => 'Europe',
            'Greece' => 'Europe',
            'Hungary' => 'Europe',
            'Iceland' => 'Europe',
            'Ireland' => 'Europe',
            'Italy' => 'Europe',
            'Kosovo' => 'Europe',
            'Latvia' => 'Europe',
            'Liechtenstein' => 'Europe',
            'Lithuania' => 'Europe',
            'Luxembourg' => 'Europe',
            'Malta' => 'Europe',
            'Moldova' => 'Europe',
            'Monaco' => 'Europe',
            'Montenegro' => 'Europe',
            'Netherlands' => 'Europe',
            'North Macedonia' => 'Europe',
            'Norway' => 'Europe',
            'Poland' => 'Europe',
            'Portugal' => 'Europe',
            'Romania' => 'Europe',
            'San Marino' => 'Europe',
            'Serbia' => 'Europe',
            'Slovakia' => 'Europe',
            'Slovenia' => 'Europe',
            'Spain' => 'Europe',
            'Sweden' => 'Europe',
            'Switzerland' => 'Europe',
            'Ukraine' => 'Europe',
            'United Kingdom' => 'Europe',
            'Vatican City' => 'Europe',

            // North America
            'Antigua and Barbuda' => 'North America',
            'Bahamas' => 'North America',
            'Barbados' => 'North America',
            'Belize' => 'North America',
            'Canada' => 'North America',
            'Costa Rica' => 'North America',
            'Cuba' => 'North America',
            'Dominica' => 'North America',
            'Dominican Republic' => 'North America',
            'El Salvador' => 'North America',
            'Grenada' => 'North America',
            'Guatemala' => 'North America',
            'Haiti' => 'North America',
            'Honduras' => 'North America',
            'Jamaica' => 'North America',
            'Mexico' => 'North America',
            'Nicaragua' => 'North America',
            'Panama' => 'North America',
            'Saint Kitts and Nevis' => 'North America',
            'Saint Lucia' => 'North America',
            'Saint Vincent and the Grenadines' => 'North America',
            'Trinidad and Tobago' => 'North America',
            'United States' => 'North America',

            // South America
            'Argentina' => 'South America',
            'Bolivia' => 'South America',
            'Brazil' => 'South America',
            'Chile' => 'South America',
            'Colombia' => 'South America',
            'Ecuador' => 'South America',
            'Guyana' => 'South America',
            'Paraguay' => 'South America',
            'Peru' => 'South America',
            'Suriname' => 'South America',
            'Uruguay' => 'South America',
            'Venezuela' => 'South America',

            // Australia
            'Australia' => 'Australia',
            'Fiji' => 'Australia',
            'Kiribati' => 'Australia',
            'Marshall Islands' => 'Australia',
            'Micronesia' => 'Australia',
            'Nauru' => 'Australia',
            'New Zealand' => 'Australia',
            'Palau' => 'Australia',
            'Papua New Guinea' => 'Australia',
            'Samoa' => 'Australia',
            'Solomon Islands' => 'Australia',
            'Tonga' => 'Australia',
            'Tuvalu' => 'Australia',
            'Vanuatu' => 'Australia',

            // Antarctica
            'Antarctica' => 'Antarctica'
        ];

        // Case-insensitive search
        foreach ($continentMapping as $countryName => $continent) {
            if (strcasecmp($countryName, $country) === 0) {
                return $continent;
            }
        }

        // Try partial matches for better results
        foreach ($continentMapping as $countryName => $continent) {
            if (stripos($countryName, $country) !== false || stripos($country, $countryName) !== false) {
                return $continent;
            }
        }

        return 'Unknown';
    }

public static function getMembershipOffers()
{
    $offers = self::find()
        ->select([
            'id' => new \yii\db\Expression('MIN(id)'), // ya MAX(id)
            'member_coin_value'
        ])
        ->where(['!=', 'member_coin_value', 0])
        ->groupBy('member_coin_value')
        ->orderBy(['member_coin_value' => SORT_DESC])
        ->asArray()
        ->all();

    $offerArray = [];
    foreach ($offers as $offer) {
        $offerArray[] = [
            'id' => $offer['id'],
            'price' => $offer['member_coin_value']
        ];
    }

    return $offerArray;
}

}
