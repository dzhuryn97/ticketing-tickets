<?php

namespace App\Domain\Order;

enum OrderStatus: int
{
    case Pending = 0;
    case Paid = 1;
    case Refunded = 2;
    case Canceled = 3;
}
