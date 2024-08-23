<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mail;
use Illuminate\Database\Eloquent\SoftDeletes;
use File;
use App\Models\UserNotificationSetting;
use Exception;

class EmailTemplates extends Model
{
	use SoftDeletes;
	protected $table = 'email_templates';

	protected $fillable = ['title', 'slug', 'subject', 'body', 'is_active', 'deleted', 'created_at', 'updated_at', 'deleted_at'];


	public static function getTemplate($slug)
	{
		$return = self::where('slug', $slug)->first();
		return ($return) ?: [];
	}

	public static function sendNotificationMailCompany($slug, $data, $to = "")
	{
		//company related emails
		try {
			if ($slug == 'company-candidate-proposal-received') {
				$companyId = $data['companyId'];
				if (isset($companyId)) {
					$companyUser = CompanyUser::where('company_id', $companyId)->pluck('user_id');
					foreach ($companyUser as $user) {
						$toUser = User::where('id', $user)->first();
						$data['name'] = (isset($toUser)) ? $toUser->firstname . " " . $toUser->lastname : "";
						$chk = UserNotificationSetting::checkPermission($user, 'CANPROREC');
						if ($chk) {
							self::sendMail($slug, $data, $toUser->email);
						}
					}
				}
			} elseif ($slug == 'company-job-posting-expire-soon') {
				$companyId = $data['companyId'];
				if (isset($companyId)) {
					$companyUser = CompanyUser::where('company_id', $companyId)->pluck('user_id');
					foreach ($companyUser as $user) {
						$toUser = User::where('id', $user)->first();
						$data['name'] = (isset($toUser)) ? $toUser->firstname . " " . $toUser->lastname : "";
						$chk = UserNotificationSetting::checkPermission($user, 'JOBPOSEXPSO');
						if ($chk) {
							self::sendMail($slug, $data, $toUser->email);
						}
					}
				}
			} elseif ($slug == 'company-job-posting-expire') {
				$companyId = $data['companyId'];
				if (isset($companyId)) {
					$companyUser = CompanyUser::where('company_id', $companyId)->pluck('user_id');
					foreach ($companyUser as $user) {
						$toUser = User::where('id', $user)->first();
						$data['name'] = (isset($toUser)) ? $toUser->firstname . " " . $toUser->lastname : "";
						$chk = UserNotificationSetting::checkPermission($user, 'JOBPOSEXP');
						if ($chk) {
							self::sendMail($slug, $data, $toUser->email);
						}
					}
				}
			} elseif ($slug == 'company-subscription-related-event') {
				$companyId = $data['companyId'];
				if (isset($companyId)) {
					$companyUser = CompanyUser::where('company_id', $companyId)->pluck('user_id');
					foreach ($companyUser as $user) {
						$toUser = User::where('id', $user)->first();
						$data['name'] = (isset($toUser)) ? $toUser->firstname . " " . $toUser->lastname : "";
						$chk = UserNotificationSetting::checkPermission($user, 'SUBSEVTO');
						if ($chk) {
							self::sendMail($slug, $data, $toUser->email);
						}
					}
				}
			}
		} catch (Exception $e) {
			return;
		}
	}

	public static function sendNotificationMailRecruiter($slug, $data, $to = "")
	{
		//recruiter related emails
		try {
			// dd($slug);
			if ($slug == 'recruiter-candidate-accepted') {
				$recruiterId = $data['recruiterId'];
				if (isset($recruiterId)) {
					$recruiter = Recruiter::where('id', $recruiterId)->first();
					$user = User::where('id', $recruiter->user_id)->first();
					$data['name'] = (isset($user)) ? $user->firstname . " " . $user->lastname : "";
					$chk = UserNotificationSetting::checkPermission($user->id, 'CANACCEPT');
					if ($chk) {
						self::sendMail($slug, $data, $user->email);
					}
				}
			} elseif ($slug == 'recruiter-candidate-rejected') {
				$recruiterId = $data['recruiterId'];
				if (isset($recruiterId)) {
					$recruiter = Recruiter::where('id', $recruiterId)->first();
					$user = User::where('id', $recruiter->user_id)->first();
					$data['name'] = (isset($user)) ? $user->firstname . " " . $user->lastname : "";
					$chk = UserNotificationSetting::checkPermission($user->id, 'CANREJECT');
					if ($chk) {
						self::sendMail($slug, $data, $user->email);
					}
				}
			} elseif ($slug == 'recruiter-payout-related-event') {
				$recruiterId = $data['recruiterId'];
				if (isset($recruiterId)) {
					$recruiter = Recruiter::where('id', $recruiterId)->first();
					$user = User::where('id', $recruiter->user_id)->first();
					$data['name'] = (isset($user)) ? $user->firstname . " " . $user->lastname : "";
					$chk = UserNotificationSetting::checkPermission($user->id, 'PAYOUTEVENTO');
					if ($chk) {
						// dd($user->email);
						self::sendMail($slug, $data, $user->email);
					}
				}
			} elseif ($slug == 'recruiter-subscription-related-event') {
				$recruiterId = $data['recruiterId'];
				if (isset($recruiterId)) {
					$recruiter = Recruiter::where('id', $recruiterId)->first();
					$user = User::where('id', $recruiter->user_id)->first();
					$data['name'] = (isset($user)) ? $user->firstname . " " . $user->lastname : "";
					$chk = UserNotificationSetting::checkPermission($user->id, 'SUBSCEVENTO');
					if ($chk) {
						self::sendMail($slug, $data, $user->email);
					}
				}
			}
		} catch (Exception $e) {
			return;
		}
	}

	public static function sendNotificationMailCandidate($slug, $data, $to = "")
	{
		//candidate related emails
		try {
			if ($slug == 'candidate-candidate-specialist-assigned') {
				// $candidateId = $data['candidateId'];
				$candidateId = $data['userId'];
				if (isset($candidateId)) {
					// $candidate = Candidate::where('id', $candidateId)->first();
					$user = User::where('id', $candidateId)->first();
					$data['name'] = (isset($user)) ? $user->firstname . " " . $user->lastname : "";
					$chk = UserNotificationSetting::checkPermission($user->id, 'CANSPA');
					if ($chk) {
						self::sendMail($slug, $data, $user->email);
					}
				}
			} elseif ($slug == 'candidate-job-application-submitted') {
				// $candidateId = $data['candidateId'];
				$candidateId = $data['userId'];
				if (isset($candidateId)) {
					// $candidate = Candidate::where('id', $candidateId)->first();
					$user = User::where('id', $candidateId)->first();
					$data['name'] = (isset($user)) ? $user->firstname . " " . $user->lastname : "";
					$chk = UserNotificationSetting::checkPermission($user->id, 'CJASC');
					if ($chk) {
						self::sendMail($slug, $data, $user->email);
					}
				}
			} elseif ($slug == 'candidate-job-application-accepted') {
				// $candidateId = $data['candidateId'];
				$candidateId = $data['userId'];
				if (isset($candidateId)) {
					// $candidate = Candidate::where('id', $candidateId)->first();
					$user = User::where('id', $candidateId)->first();
					$data['name'] = (isset($user)) ? $user->firstname . " " . $user->lastname : "";
					$chk = UserNotificationSetting::checkPermission($user->id, 'CJAPAC');
					if ($chk) {
						self::sendMail($slug, $data, $user->email);
					}
				}
			} elseif ($slug == 'candidate-job-application-rejected') {
				// $candidateId = $data['candidateId'];
				$candidateId = $data['userId'];
				if (isset($candidateId)) {
					// $candidate = Candidate::where('id', $candidateId)->first();
					$user = User::where('id', $candidateId)->first();
					$data['name'] = (isset($user)) ? $user->firstname . " " . $user->lastname : "";
					$chk = UserNotificationSetting::checkPermission($user->id, 'CAJAREJ');
					if ($chk) {
						self::sendMail($slug, $data, $user->email);
					}
				}
			}
		} catch (Exception $e) {
			return;
		}
	}

	public static function sendMail($slug, $data, $to)
	{
		$template = self::getTemplate($slug);
		if ($template) {
			$mailBody = $template->body;
			$variables = [];
			$values = [];
			foreach ($data as $key => $value) {
				$variables[] = "{" . $key . "}";
				$values[] = $value;
			}
			$mailBody = str_replace($variables, $values, $mailBody);
			$ccEmails = [];
			$ccList = EmailTemplatesCc::selectRaw('email_cc')->where('template_id', $template->id)->get()->toArray();

			foreach ($ccList as $key => $value) {
				$ccEmails[] = $value['email_cc'];
			}

			try {
				Mail::send([], [], function ($message) use ($mailBody, $template, $to, $ccEmails) {
					$message->to($to)
						// ->cc($ccEmails)
						->subject($template->subject)
						->setBody($mailBody, 'text/html'); // for HTML rich messages
				});
			} catch (Exception $e) { }
			return 1;
		}
	}

	public static function uploadCKeditorImage($request)
	{
		$fileObject = $request->file('upload');
		$photo = $fileObject;
		$ext = $fileObject->extension();
		$filename = rand() . '_' . time() . '.' . $ext;
		$filePath = public_path() . '/assets/images/ckimages';
		if (!File::exists($filePath)) {
			File::makeDirectory($filePath);
		}

		$img = Image::make($photo->path());
		// $img->resize(50, 50, function ($const) {
		//     $const->aspectRatio();
		// })->save($filePath.'/'.$filename);
		$photo->move($filePath . '/', $filename);

		$CKEditorFuncNum = $request->input('CKEditorFuncNum');
		$url = asset('/public/assets/images/ckimages/' . $filename);
		$msg = 'Image uploaded successfully';
		$response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

		@header('Content-type: text/html; charset=utf-8');
		echo $response;
	}
}
