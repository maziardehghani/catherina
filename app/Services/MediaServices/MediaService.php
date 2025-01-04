<?php

namespace App\Services\MediaServices;


use App\Entities\Media;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use function public_path;


class MediaService
{
    private static UploadedFile $file;
    private static string $type;
    private static $model;
    private static $id;
    private static $filename;
    private static $extension;
    private static $em;


    public static function upload($file, string $type, $model, $id)
    {
        self::$file = $file;
        self::$type = $type;
        self::$model = ucfirst($model);
        self::$id = $id;
        self::$filename = self::generateName();
        self::$extension = self::generateExtension();
        self::$em = app(EntityManagerInterface::class);


        return self::saveMedia();
    }

    public static function uploadIf(bool $condition, $file, string $type, $model, $id)
    {

        if (!$condition) {
            return null;
        }

        return self::upload($file, $type, $model, $id);
    }

    private static function saveMedia()
    {
        self::$file->move(public_path(self::generatePath()), self::$filename . '.' . self::$extension);

        $media = new Media();

        $media->setUrl(self::generatePath() . '/' . self::$filename . '.' . self::$extension);
        $media->setName(self::$filename . '.' . self::$extension);
        $media->setType(self::$type);
        $media->setMediableId(self::$id);
        $media->setMediableType(self::getClass(self::$model));

        self::$em->persist($media);
        self::$em->flush();

        return $media;

    }

    public static function delete($medias)
    {
        $em = app(EntityManagerInterface::class);

        if (is_array($medias)) {

            foreach ($medias as $media) {

                File::delete(public_path($media->getUrl()));

                $em->remove($media);
                $em->flush();

            }
            return null;
        }

        File::delete(public_path($medias->getUrl()));

        $em->remove($medias);
        $em->flush();


    }

    public static function replace($file, string $type, $model, $id)
    {
        $medias = app(EntityManagerInterface::class)
                ->getRepository(Media::class)
                ->getMedias($id, self::getClass($model), $type);



        if (!empty($medias)) {
            self::delete($medias);
        }


        self::uploadIf(
            !is_null($file),
            $file,
            $type,
            $model,
            $id
        );

    }

    private static function generateName()
    {
        return uniqid();
    }

    private static function getClass($model): string
    {
        return "App\Entities\\" . ucfirst($model);
    }

    private static function get_type(): string
    {
        return explode('/', self::$file->getMimeType())[0];
    }

    private static function generateExtension(): string
    {
        return strtolower(self::$file->getClientOriginalExtension());
    }

    private static function generatePath()
    {
        $modelName = class_basename(self::getClass(self::$model));
        return "/media/$modelName/" . self::$id;
    }


}
