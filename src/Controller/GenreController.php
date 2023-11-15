<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpClient\Internal\CurlClientState;
use Symfony\Component\HttpClient\Response\CurlResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Config\FrameworkConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use App\Entity\Genre;

class GenreController extends AbstractController
{
   

    #[Route('/movie/genres', name: 'app_genres', methods: ['GET'])]
    public function index(ManagerRegistry $doctrine): JsonResponse
    {
        $token = $_ENV['MOVIEDB_TOKEN'];
        $genres = $doctrine->getRepository(Genre::class)->findAll();
        if(count($genres) == 0){
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.themoviedb.org/3/genre/movie/list?language=en",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                  "Authorization: Bearer {$token}",
                  "accept: application/json"
                ],
              ]);
              
              $response = curl_exec($curl);
              $err = curl_error($curl);
              
              curl_close($curl);
              
              if ($err) {
                echo "cURL Error #:" . $err;
              } else {
                $genre_data = json_decode($response, true);
                foreach ($genre_data['genres'] as $genre) {
                    $data_genres = new Genre();
                    $data_genres->setIdGenreMoviedb($genre['id']);
                    $data_genres->setDescription($genre['name']);
                    $entityManager = $doctrine->getManager();
                    $entityManager->persist($data_genres);
                    $entityManager->flush();
                }

              }
        }
        $data = [];
        foreach ($genres as $genre) {
            $data[] = [
                'id' => $genre->getId(),
                'idGenreMoviedb' => $genre->getIdGenreMoviedb(),
                'description' => $genre->getDescription(),
            ];
         }

        return $this->json($data);
            
       
    }
    
}


