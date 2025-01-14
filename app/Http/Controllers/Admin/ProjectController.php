<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProjectMembersType;
use App\Events\FarabourseDataEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Http\Requests\ProjectUserExpertRequest;
use App\Http\Resources\FarabourseResource;
use App\Http\Resources\MediaResource;
use App\Http\Resources\ProjectInvestorsResources;
use App\Http\Resources\ProjectListResource;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\ProjectStatusLogResources;
use App\Http\Resources\ProjectUserExpertsResource;
use App\Http\Resources\User\UserResource;
use App\Models\FarabourseProject;
use App\Models\Media;
use App\Models\Project;
use App\Models\ProjectMembersInfo;
use App\Models\ProjectUserExpert;
use App\Repositories\City\CityRepository;
use App\Repositories\Media\MediaRepository;
use App\Repositories\Project\ProjectRepository;
use App\Repositories\ProjectsUserExperts\ProjectUserExpertsRepository;
use App\Repositories\User\UserRepository;
use App\Services\FarabourseServices\FarabourseService;
use App\Services\MediaServices\MediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ProjectController extends Controller
{
    public function __construct(
        private ProjectRepository $projectRepository,
    )
    {}

    /**
     * @param Request $request filtering params from query strings
     * @return JsonResponse containing projects list
     *
     */
    public function index(Request $request): JsonResponse
    {
        $projects = $this->projectRepository->paginate($request->page ?? 1);

        return response()->success([
            'data' => ProjectResource::collection($projects['data']),
            'total' => $projects['total'],
            'current_page' => $projects['current_page'],
            'per_page' => $projects['per_page'],
        ], 'اطلاعات با موفقیت دریافت شد');
    }

    public function show(Project $project): JsonResponse
    {
        return response()->success(new ProjectResource($project->load(['experts','city','state','user'])), 'اطلاعات با موفقیت دریافت شد');
    }


    /**
     * @param ProjectRequest $request
     * @return JsonResponse containing success or error details
     *
     * process of storing project have two steps
     *
     * first step is for storing the string or integer types of data
     *
     * second step is for storing the documents or files or logo type data
     *
     * after changing status of project the observer will save the log of status
     *
     */

    public function storeSpecifications(ProjectRequest $request): JsonResponse
    {
        $project = $this->projectRepo->updateOrStore($request->validated());

        return response()->success($project->id, 'اطلاعات با موفقیت دریافت شد');
    }

    /**
     * @param ProjectRequest $request
     * @param Project $project
     * @return JsonResponse containing error or success details
     *
     *
     */
    public function updateProjectInformation(ProjectRequest $request, Project $project): JsonResponse
    {
        $this->projectRepo->update($project, $request->validated());

        return response()->success($project->id, 'اطلاعات با موفقیت دریافت شد');
    }


    /**
     * @param ProjectRequest $request
     * @param Project $project
     * @return JsonResponse containing error or success details
     *
     *
     */
    public function updateFinancialInformation(ProjectRequest $request, Project $project): JsonResponse
    {
        $this->projectRepo->update($project, $request->validated());

        return response()->success($project->id, 'اطلاعات با موفقیت دریافت شد');
    }


    /**
     * @param ProjectRequest $request
     * @param Project $project
     * @return JsonResponse containing error or success details
     *
     *
     */
    public function updateStatus(ProjectRequest $request, Project $project): JsonResponse
    {
        $this->projectRepo->update($project, $request->validated());
        return response()->success($project->id, 'اطلاعات با موفقیت دریافت شد');
    }


    public function updateFarabourseCode(Project $project, ProjectRequest $request): JsonResponse
    {

        $this->projectRepo->updateFarabourseCode($project, $request->validated());


        event(new FarabourseDataEvent($project->id, $request->trace_code));

        return response()->success(null, 'اطلاعات با موفقیت ذخیره شد');
    }

    public function getFarabourseProject(Project $project, ProjectRequest $request): JsonResponse
    {
        FarabourseProject::query()->updateOrCreate(
            [
                'project_id' => $project->id,
            ],
            [
                'project_id' => $project->id,
            ]);
        DB::beginTransaction();
        try {

            $farabourseInfo = FarabourseService::getProjectInfo(trim($request->trace_code));

            /**
             *
             * update farabourse data by each time using this method or create if not data exist
             *
             */

            FarabourseProject::query()->updateOrCreate(
                [
                    'project_id' => $project->id,
                ]
                , [
                'project_id' => $project->id,
                'trace_code' => trim($request->trace_code),
                'creation_date' => $farabourseInfo['Creation Date'],
                'persian_name' => $farabourseInfo['Persian Name'],
                'persian_symbol' => $farabourseInfo['Persoan Approved Symbol'],
                'english_name' => $farabourseInfo['English Name'],
                'english_symbol' => $farabourseInfo['English Approved Symbol'],
                'industry_group' => $farabourseInfo['Industry Group Description'],
                'sub_industry_group' => $farabourseInfo['Sub Industry Group Description'],
                'persian_subject' => $farabourseInfo['Persian Subject'],
                'english_subject' => $farabourseInfo['English Subject'],
                'unit_price' => $farabourseInfo['Unit Price'],
                'total_unit' => $farabourseInfo['Total Units'],
                'company_units' => $farabourseInfo['Company Unit Counts'],
                'total_amounts' => $farabourseInfo['Total Price'],
                'crowd_funding_id' => $farabourseInfo['Crowd Funding Type ID'],
                'crowd_funding_description' => $farabourseInfo['Crowd Funding Type Description'],
                'float_crowd_funding_type_description' => $farabourseInfo['Float Crowd Funding Type Description'],
                'minimum_require_price' => $farabourseInfo['Minimum Required Price'],
                'real_person_minimum_available_price' => $farabourseInfo['Real Person Minimum Availabe Price'],
                'real_person_maximum_available_price' => $farabourseInfo['Real Person Maximum Available Price'],
                'legal_person_minimum_available_price' => $farabourseInfo['Legal Person Minimum Availabe Price'],
                'legal_person_maximum_available_price' => $farabourseInfo['Legal Person Maximum Availabe Price'],
                'underwriting_duration' => $farabourseInfo['Underwriting Duration'],
                'suggested_underwriting_start_date' => $farabourseInfo['Suggested Underwriting Start Date'],
                'suggested_underwriting_end_date' => $farabourseInfo['Suggested Underwriting End Date'],
                'approved_underwriting_start_date' => $farabourseInfo['Approved Underwriting Start Date'],
                'approved_underwriting_end_date' => $farabourseInfo['Approved Underwriting End Date'],
                'project_start_date' => $farabourseInfo['Project Start Date'],
                'project_end_date' => $farabourseInfo['Project End Date'],
                'settlement_description' => $farabourseInfo['Settlement Description'],
                'project_status_description' => $farabourseInfo['Project Status Description'],
                'project_status_id' => $farabourseInfo['Project Status ID'],
                'persian_suggested_underwriting_start_date' => $farabourseInfo['Persian Suggested Underwiring Start Date'],
                'persian_suggested_underwriting_end_date' => $farabourseInfo['Persian Suggested Underwiring Start Date'],
                'persian_approved_underwriting_start_date' => $farabourseInfo['Persian Approved Underwriting Start Date'],
                'persian_approved_underwriting_end_date' => $farabourseInfo['Persian Approved Underwriting End Date'],
                'persian_project_start_date' => $farabourseInfo['Persian Project Start Date'],
                'persian_project_end_date' => $farabourseInfo['Persian Project End Date'],
                'persian_creation_Date' => $farabourseInfo['Persian Creation Date'],
                'sum_of_founding_provided' => $farabourseInfo['SumOfFundingProvided'],
                'number_of_finance_provider' => $farabourseInfo['Number of Finance Provider'],
            ]);

            /**
             *
             * Faraboure also returns a list of board members and shareholders
             * of the investing company that we have to store this information
             *
             */

            ProjectMembersInfo::query()->where('project_id', $project->id)->delete();

            $legal_person_stake_holders = $farabourseInfo['List Of Project Board Members'];

            collect($legal_person_stake_holders)->map(function ($legal_person_stake_holder) use ($project) {
                ProjectMembersInfo::query()->create(
                    [
                        'project_id' => $project->id,
                        'first_name' => $legal_person_stake_holder['First Name'],
                        'last_name' => $legal_person_stake_holder['Last Name'],
                        'position' => $legal_person_stake_holder['Organization Post Description'],
                        'percent' => null,
                        'is_owner_signiture' => $legal_person_stake_holder['Is Agent from a Company'],
                        'type' => ProjectMembersType::STAKMEMBER->value,
                    ]);
            });

            $legal_person_share_holders = $farabourseInfo['List Of Project Big Share Holders'];

            collect($legal_person_share_holders)->map(function ($legal_person_share_holder) use ($project) {
                ProjectMembersInfo::query()->create([
                    'project_id' => $project->id,
                    'first_name' => $legal_person_share_holder['First Name / Company Name'],
                    'last_name' => $legal_person_share_holder['Last Name / CEO Name'],
                    'position' => $legal_person_share_holder['Shareholder Type'],
                    'percent' => floor($legal_person_share_holder['Share Percent']),
                    'is_owner_signiture' => null,
                    'type' => ProjectMembersType::SHAREHOLDER->value,
                ]);
            });

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            return response()->error('خطا در ذخیره اطلاعات');
        }

        return response()->success(null, 'اطلاعات با موفقیت ذخیره شد');
    }


    /**
     * @param Project $project
     * @return JsonResponse containing error or success details
     *
     * at the delete process the projects files doesn't remove , just the record at database delete
     * also the delete method is type of softDelete
     *
     *
     */
    public function delete(Project $project): JsonResponse
    {
        $this->projectRepo->delete($project);

        return response()->success(null, 'اطلاعات با موفقیت حذف شد');
    }

    /**
     * @param ProjectUserExpertRequest $request
     * @param Project $project
     * @return JsonResponse containing error or success details
     *
     * each project has some experts who are also admin in the system
     *
     * the experts can be chosen by admin for each project
     *
     */
    public function addExpert(ProjectUserExpertRequest $request, Project $project): JsonResponse
    {
        $request->merge([
            'project_id' => $project->id,
        ]);

        $this->projectUserExpertsRepo->store($request->all());

        return response()->success(null, 'اطلاعات با موفقیت ذخیره شد');
    }

    /**
     * @param Project $project
     * @return JsonResponse containing list of experts for project
     *
     */

    public function experts(Project $project): JsonResponse
    {
        $userExperts = $this->projectUserExpertsRepo->whereProject($project);

        return response()->success(ProjectUserExpertsResource::collection($userExperts), 'اطلاعات با موفقیت دریافت شد');
    }

    public function deleteExpert(ProjectUserExpert $projectUserExpert)
    {
        $this->projectUserExpertsRepo->delete($projectUserExpert);
        return response()->success(null, 'اطلاعات با موفقیت خذف شد');
    }

    /**
     * @param Project $project
     * @return JsonResponse containing the list of project files or documents
     *
     *
     */
    public function files(Project $project): JsonResponse
    {
        return response()->success(MediaResource::collection($project->medias));
    }

    public function financeFiles(Project $project): JsonResponse
    {
        $medias = $this->projectRepo->getFinanceFiles($project);

        return response()->success(MediaResource::collection($medias));
    }

    public function projectInvestors(Project $project): JsonResponse
    {
        $invoices = $this->projectRepo->getInvoicesOfProject($project);

        return response()->success(ProjectInvestorsResources::collection($invoices));
    }

    /**
     * @param Project $project
     * @param ProjectRequest $request
     * @return JsonResponse containing error or success response
     *
     * each project have some information that related to in farabourse
     * expert can receive these necessary information from farabourse
     *
     * we use farabourse api to get this info
     *
     */

    /**
     * @param Project $project
     * @return JsonResponse list of farabourse information about project
     *
     */

    public function farabourse(Project $project): JsonResponse
    {
        return response()->success(new FarabourseResource($project->farabourse), 'اطلاعات با موفقیت دریافت شد');
    }


    /**
     * @param Project $project
     * @return JsonResponse contain a list of project status logs
     *
     *
     * the logs which saved whenever status changed
     *
     */

    public function projectStatusLogs(Project $project): JsonResponse
    {
        return response()->success(ProjectStatusLogResources::collection($project->projectStatusLogs), 'اطلاعات با موفقیت دریافت شد');
    }

    public function participation(Project $project): JsonResponse
    {
        $this->projectRepo->toggleParticipation($project);

        return response()->success([]);
    }


    public function projectsList(): JsonResponse
    {
        $projects = Project::all();

        return response()->success(ProjectListResource::collection($projects));
    }
}
