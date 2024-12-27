<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Statuses;
use App\Http\Controllers\Controller;
use App\Http\Requests\TicketRequest;
use App\Http\Resources\TicketResource;
use App\Models\Status;
use App\Models\Ticket;
use App\Repositories\Ticket\TicketRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TicketController extends Controller
{
    public object $ticketRepo;
    public function __construct()
    {
        $this->ticketRepo = new TicketRepository();
    }


    /**
     * @param Request $request
     * @return JsonResponse containing list of tickets
     *
     */
    public function index(Request $request):JsonResponse
    {
        $tickets = Ticket::query()
            ->where('parent_id', null)
            ->whereStatus($request->status)
            ->latest()
            ->paginate();

        return response()->success(TicketResource::collection($tickets), 'اطلاعات با موفقیت دریافت شد');
    }

    public function show(Ticket $ticket):JsonResponse
    {
        return response()->success(new TicketResource($ticket->load('child')), 'اطلاعات با موفقیت دریافت شد');
    }

    /**
     * @param TicketRequest $request
     * @param Ticket $ticket
     * @return JsonResponse contain error or success response
     *
     * admin can answer the tickets of users
     *
     */
    public function answer(TicketRequest $request, Ticket $ticket):JsonResponse
    {
        $request->merge([
            'parent_id' => $ticket->getKey(),
            'user_id' => auth()->id(),
            'category' => $ticket->category,
            'status_id' => Status::query()
                ->whereType(Ticket::class)
                ->whereTitle(Statuses::ANSWERED)
                ->first()
                ->id,
        ]);

        $this->ticketRepo->store($request->all());
        $this->ticketRepo->update($ticket, [
            'status_id' => Status::query()
                ->whereType(Ticket::class)
                ->whereTitle(Statuses::ANSWERED)
                ->first()
                ->id,
        ]);

        return response()->success(null, 'اطلاعات با موفقیت ذخیره شد');
    }

    /**
     * @param TicketRequest $request
     * @param Ticket $ticket
     * @return JsonResponse contain error or success responses
     *
     * update the tickets of users for example update status of ticket to closed
     *
     */
    public function update(TicketRequest $request, Ticket $ticket):JsonResponse
    {
        $this->ticketRepo->update($ticket,$request->all());

        return response()->success(null, 'اطلاعات با موفقیت ذخیره شد');
    }

    public function delete(Ticket $ticket):JsonResponse
    {
        $this->ticketRepo->delete($ticket);
        return response()->success(null, 'اطلاعات با موفقیت حذف شد');
    }
}
