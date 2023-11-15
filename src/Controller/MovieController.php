<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpClient\Internal\CurlClientState;
use Symfony\Component\HttpClient\Response\CurlResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Config\FrameworkConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use App\Entity\Movie;
use App\Entity\MovieGenre;

class MovieController extends AbstractController
{
   

    #[Route('/movie', name: 'app_movie', methods: ['GET'])]
    public function index(ManagerRegistry $doctrine): JsonResponse
    {
        $movies = $doctrine->getRepository(Movie::class)->findAll();
        if (!$movies) {
   
          return $this->json('No movies found', 404);
      }
        $data = [];
        foreach ($movies as $post) {
            $data[] = [
                'id' => $post->getId(),
                'title' => $post->getTitle(),
                'description' => $post->getDescription(),
            ];
         }

        return $this->json($data);
            
       
    }

    #[Route('/movie/add', name: 'app_movie_add', methods:['post'] )]
    public function create(ManagerRegistry $doctrine, Request $request): Response
    {
        $movie = new Movie();
        $movie->setTitle($request->request->get('title'));
        $movie->setIdMoviedb($request->request->get('moviedb_id'));
        $movie_id = $movie->getIdMoviedb();

        $url = "https://api.themoviedb.org/3/movie/{$movie_id}?language=en-US";
        $token = $_ENV['MOVIEDB_TOKEN'];
        
        $curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => $url,
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
  $movie_data = json_decode($response, true);
}
  
  $movie ->setPoster($movie_data['poster_path']);
  $movie ->setVote($movie_data['vote_average']);
  $movie ->setDescription($movie_data['overview']);
   
        $entityManager = $doctrine->getManager();
        $entityManager->persist($movie);
        $entityManager->flush();
  
        return new Response('Saved new movie with id '.$movie->getId());
}

    #[Route('/movie/{id}', name: 'app_movie_show', methods: ['GET'])]
    public function show(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $movie = $doctrine->getRepository(Movie::class)->find($id);
        if (!$movie) {
   
            return $this->json('No movie found for id '.$id, 404);
        }
        $data = [
            'id' => $movie->getId(),
            'title' => $movie->getTitle(),
            'description' => $movie->getDescription(),
        ];

        return $this->json($data);
    }

    #[Route('/movie/{id}', name: 'app_movie_delete', methods: ['DELETE'])]
    public function delete(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $movie = $doctrine->getRepository(Movie::class)->find($id);
        if (!$movie) {
   
            return $this->json('No movie found for id '.$id, 404);
        }
        $entityManager = $doctrine->getManager();
        $entityManager->remove($movie);
        $entityManager->flush();

        return $this->json('Movie deleted successfully with id'. $id);
    }

    #[Route('/movie/{id}', name: 'app_movie_update', methods: ['PUT'])]
    public function update(ManagerRegistry $doctrine, Request $request, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $movie = $doctrine->getRepository(Movie::class)->find($id);
        if (!$movie) {
   
            return $this->json('No movie found for id '.$id, 404);
        }
        
        $movie->setTitle($request->request->get('title'));
        $movie->setDescription($request->request->get('description'));
        $entityManager->flush();

        return $this->json('Movie updated successfully with id '. $id);
    }
    
}


