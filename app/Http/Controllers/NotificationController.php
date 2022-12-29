<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Services\NotificationService;

class NotificationController extends Controller
{
    private $service;

    public function __construct(NotificationService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/api/notifications",
     *     tags={"Notification"},
     *     summary="Get all notification list",
     *     description="Returns list of notifications by auth id",
     *     operationId="notification",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     *      @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     ),
     *
     *  )
     */
    public function index()
    {
        return $this->success($this->service->getUserUnreadNotifications());
    }

    /**
     * @OA\Get(
     *     path="/api/notifications/all",
     *     tags={"Notification"},
     *     summary="Get all notification list",
     *     description="Returns list of notifications",
     *     operationId="notifications",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     *      @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     ),
     *
     *  )
     */
    public function all()
    {
        return $this->success($this->service->getAll());
    }

    /**
     * @OA\Get(
     *     path="/api/notifications/{id}",
     *     tags={"Notification"},
     *     summary="Get one data",
     *     description="Get one",
     *     operationId="showNotification",
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         description="ID for notification data",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     *      @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     ),
     *  )
     */
    public function show(Notification $notification)
    {
        $this->service->setNotificationAsRead($notification);
        return $this->success($notification);
    }
}
