<?php

namespace App\Rules;

use App\Entities\UsersInfosValues;
use App\Models\UserInfoValue;
use Closure;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueUserInfoValue implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $entityManager = app(EntityManagerInterface::class);

        $query = $entityManager->createQueryBuilder()
            ->select('uiv')
            ->from(UsersInfosValues::class, 'uiv')
            ->join('uiv.usersInfosTitles', 'uit')
            ->where('uit.title = :title')
            ->andWhere('uiv.value = :value')
            ->setParameter('title' , $attribute)
            ->setParameter('value' , $value);

        if(request()->user?->getId())
        {
            $query->andWhere('uiv.user != :id')
            ->setParameter('id' , request()->user?->getId());
        }

        $valueExist = $query->getQuery()
            ->getOneOrNullResult();

        if ($valueExist) {
            $fail(":attribute قبلا انتخاب شده است");
        }

    }
}
