<?php

namespace Shopware\Bundle\CustomerSearchBundle\Gateway;

use Shopware\Bundle\StoreFrontBundle\Struct\Customer\Group;
use Shopware\Bundle\StoreFrontBundle\Struct\Extendable;

class CustomerStruct extends Extendable
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $encoder;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var int
     */
    protected $active;

    /**
     * @var int
     */
    protected $accountMode;

    /**
     * @var string
     */
    protected $confirmationKey;

    /**
     * @var int
     */
    protected $paymentId;

    /**
     * @var \DateTime
     */
    protected $firstLogin;

    /**
     * @var \DateTime
     */
    protected $lastLogin;

    /**
     * @var boolean
     */
    protected $newsletter;

    /**
     * @var string
     */
    protected $validation;

    /**
     * @var int
     */
    protected $affiliate;

    /**
     * @var Group
     */
    protected $customerGroup;

    /**
     * @var int
     */
    protected $paymentPreset;

    /**
     * @var int
     */
    protected $languageId;

    /**
     * @var int
     */
    protected $shopId;

    /**
     * @var string
     */
    protected $referer;

    /**
     * @var string
     */
    protected $internalComment;

    /**
     * @var int
     */
    protected $failedLogins;

    /**
     * @var \DateTime|null
     */
    protected $lockedUntil;

    /**
     * @var int
     */
    protected $defaultBillingAddressId;

    /**
     * @var int
     */
    protected $defaultShippingAddressId;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $salutation;

    /**
     * @var string
     */
    protected $firstname;

    /**
     * @var string
     */
    protected $lastname;

    /**
     * @var \DateTime|null
     */
    protected $birthday;

    /**
     * @var string
     */
    protected $number;

    /**
     * @var int
     */
    protected $age;

    /**
     * @var AddressStruct
     */
    protected $shippingAddress;

    /**
     * @var AddressStruct
     */
    protected $billingAddress;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEncoder()
    {
        return $this->encoder;
    }

    /**
     * @param string $encoder
     */
    public function setEncoder($encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return int
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param int $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return int
     */
    public function getAccountMode()
    {
        return $this->accountMode;
    }

    /**
     * @param int $accountMode
     */
    public function setAccountMode($accountMode)
    {
        $this->accountMode = $accountMode;
    }

    /**
     * @return string
     */
    public function getConfirmationKey()
    {
        return $this->confirmationKey;
    }

    /**
     * @param string $confirmationKey
     */
    public function setConfirmationKey($confirmationKey)
    {
        $this->confirmationKey = $confirmationKey;
    }

    /**
     * @return int
     */
    public function getPaymentId()
    {
        return $this->paymentId;
    }

    /**
     * @param int $paymentId
     */
    public function setPaymentId($paymentId)
    {
        $this->paymentId = $paymentId;
    }

    /**
     * @return \DateTime
     */
    public function getFirstLogin()
    {
        return $this->firstLogin;
    }

    /**
     * @param \DateTime $firstLogin
     */
    public function setFirstLogin($firstLogin)
    {
        $this->firstLogin = $firstLogin;
    }

    /**
     * @return \DateTime
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * @param \DateTime $lastLogin
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;
    }

    /**
     * @return bool
     */
    public function isNewsletter()
    {
        return $this->newsletter;
    }

    /**
     * @param bool $newsletter
     */
    public function setNewsletter($newsletter)
    {
        $this->newsletter = $newsletter;
    }

    /**
     * @return string
     */
    public function getValidation()
    {
        return $this->validation;
    }

    /**
     * @param string $validation
     */
    public function setValidation($validation)
    {
        $this->validation = $validation;
    }

    /**
     * @return int
     */
    public function getAffiliate()
    {
        return $this->affiliate;
    }

    /**
     * @param int $affiliate
     */
    public function setAffiliate($affiliate)
    {
        $this->affiliate = $affiliate;
    }

    /**
     * @return Group
     */
    public function getCustomerGroup()
    {
        return $this->customerGroup;
    }

    /**
     * @param Group $customerGroup
     */
    public function setCustomerGroup($customerGroup)
    {
        $this->customerGroup = $customerGroup;
    }

    /**
     * @return int
     */
    public function getPaymentPreset()
    {
        return $this->paymentPreset;
    }

    /**
     * @param int $paymentPreset
     */
    public function setPaymentPreset($paymentPreset)
    {
        $this->paymentPreset = $paymentPreset;
    }

    /**
     * @return int
     */
    public function getLanguageId()
    {
        return $this->languageId;
    }

    /**
     * @param int $languageId
     */
    public function setLanguageId($languageId)
    {
        $this->languageId = $languageId;
    }

    /**
     * @return int
     */
    public function getShopId()
    {
        return $this->shopId;
    }

    /**
     * @param int $shopId
     */
    public function setShopId($shopId)
    {
        $this->shopId = $shopId;
    }

    /**
     * @return string
     */
    public function getReferer()
    {
        return $this->referer;
    }

    /**
     * @param string $referer
     */
    public function setReferer($referer)
    {
        $this->referer = $referer;
    }

    /**
     * @return string
     */
    public function getInternalComment()
    {
        return $this->internalComment;
    }

    /**
     * @param string $internalComment
     */
    public function setInternalComment($internalComment)
    {
        $this->internalComment = $internalComment;
    }

    /**
     * @return int
     */
    public function getFailedLogins()
    {
        return $this->failedLogins;
    }

    /**
     * @param int $failedLogins
     */
    public function setFailedLogins($failedLogins)
    {
        $this->failedLogins = $failedLogins;
    }

    /**
     * @return \DateTime|null
     */
    public function getLockedUntil()
    {
        return $this->lockedUntil;
    }

    /**
     * @param \DateTime|null $lockedUntil
     */
    public function setLockedUntil($lockedUntil)
    {
        $this->lockedUntil = $lockedUntil;
    }

    /**
     * @return int
     */
    public function getDefaultBillingAddressId()
    {
        return $this->defaultBillingAddressId;
    }

    /**
     * @param int $defaultBillingAddressId
     */
    public function setDefaultBillingAddressId($defaultBillingAddressId)
    {
        $this->defaultBillingAddressId = $defaultBillingAddressId;
    }

    /**
     * @return int
     */
    public function getDefaultShippingAddressId()
    {
        return $this->defaultShippingAddressId;
    }

    /**
     * @param int $defaultShippingAddressId
     */
    public function setDefaultShippingAddressId($defaultShippingAddressId)
    {
        $this->defaultShippingAddressId = $defaultShippingAddressId;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getSalutation()
    {
        return $this->salutation;
    }

    /**
     * @param string $salutation
     */
    public function setSalutation($salutation)
    {
        $this->salutation = $salutation;
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return \DateTime|null
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param \DateTime|null $birthday
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param string $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @param int|null $age
     */
    public function setAge($age)
    {
        $this->age = $age;
    }

    /**
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @return AddressStruct
     */
    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }

    /**
     * @param AddressStruct $shippingAddress
     */
    public function setShippingAddress($shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;
    }

    /**
     * @return AddressStruct
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * @param AddressStruct $billingAddress
     */
    public function setBillingAddress($billingAddress)
    {
        $this->billingAddress = $billingAddress;
    }
}
