<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Room;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Cette classe de test utilise le trait DatabaseTransactions,
 * sans rentrer dans les détails, cela permet d'enregistrer
 * un état de la base de données au moment où l'on démarre
 * les tests, et de le restaurer une fois les tests terminés.
 * Concrètement pour nous ici, cela nous permet de faire nos tests,
 * notamment les tests de création de données, et de les "supprimer"
 * une fois ceux ci terminés. Sinon, les données créées via l'API
 * le seraient vraiment et resteraient dans la base de données, ce qui
 * est rarement souhaitable.
 * 
 * Ce fichier contient de nombreux commentaires, ceci dans un but
 * pédagogique pour expliquer en détail ce que l'on fait. Il ne faut
 * pas, bien entendu, prendre cela comme exemple et commenter à ce point
 * son code sur vos propres codebases.
 * Un code bien écrit, bien ordonné, suffisamment aéré (pas trop non plus)
 * avec des noms de variables et de méthodes clairs et qui respecte
 * toujours la même structure (coding guidelines à définir ensemble)
 * dispense dans la grande majorité des cas d'avoir à ajouter des commentaires !
 */
class RoomTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test pour vérifier que la route index retourne le code correct.
     * Par défaut, si rien n'est précisé et que tout s'est bien passé,
     * c'est le code HTTP 200.
     */
    public function test_index_is_rendered_successfully(): void
    {
        $response = $this->get('/api/rooms');

        $response->assertStatus(200);
    }

    /**
     * Test pour vérifier que les données retournées par la route index
     * correspondent à la structure que nous attendons, c'est à dire un
     * tableau JSON de "rooms" dont chaque entrée contient les
     * propriétés du modèle Room.
     * Nous avons défini cela dans le RoomController.
     * 
     * Bien entendu, si vous ajouter de nouvelle propriétés à votre
     * modèle, il faut penser à aller adapter vos tests en conséquences.
     * Les tests, comme le reste de votre code, est amené à changer au fur
     * et à mesure des évolutions fonctionnelles que vous apportez.
     */
    public function test_index_contains_proper_rooms_structure(): void
    {
        $response = $this->get('/api/rooms');

        $response->assertJsonStructure([
            'rooms' => [
                '*' => [
                    'id',
                    'name',
                    'is_booked',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
    }

    /**
     * De la même manière que pour la route index,
     * nous vérifions la route show.
     */
    public function test_show_returns_room_successfully(): void
    {
        /**
         * Nous créons dans la base de données une room aléatoire
         * grâce à la factory que nous avons créée.
         */
        $room = Room::factory()->create();

        /**
         * Nous essayons de contacter la route telle que nous l'avons définie
         * dans notre router (fichier routes/api.php)
         */
        $response = $this->getJson("/api/room/{$room->id}");

        /**
         * Nous pouvons vérifier le statut en même temps ou séparemment comme pour index,
         * c'est un choix à faire, mais il faut ensuite s'y tenir. Ici, je montre
         * plusieurs façon de faire les tests dans le cadre d'un cours, mais dans un
         * "vrai" projet, il faut convenir d'une structure et de toujours la respecter,
         * c'est-à-dire soit un test séparé pour le statut et un autre pour les données,
         * soit les deux en même temps par exemple.
         */
        $response->assertStatus(200);

        // Nous vérifions que la route nous retourne bien les données que nous attendions.
        $response->assertJson([
            'id' => $room->id,
            'name' => $room->name,
            'is_booked' => $room->is_booked,
        ]);
    }

    /**
     * Ici, nous allons, si tout se passe bien, créer une nouvelle Room dans la
     * base de données. Si nous n'utilisions pas le trait indiqué précédemment,
     * les données créées resteraient dans la table après le test.
     */
    public function test_new_room_is_stored_successfully(): void
    {
        /**
         * Nous pouvons utiliser notre factory, qui nous a déjà servi dans le seeder,
         * pour générer une room avec des données aléatoire.
         * Attention à ne pas utiliser la méthode create() qui enregistre les infos dans
         * la base de données. Ici, nous utilisons make() qui crée seulement l'objet.
         * Vous pouvez aller voir les méthodes de la classe factory de Laravel pour
         * en savoir plus.
         */
        $room = Room::factory()->make();

        // Nous envoyons les données générées en paramètres de notre route POST.
        $response = $this->postJson('/api/room', [
            'name' => $room->name,
            'is_booked' => $room->is_booked,
        ]);


        /**
         * Comme nous avons défini dans la méthode store notre controller
         * qu'une création retourne un code 201 plutôt que 200 (c'est une convention),
         * nous vérifions que c'est bien le cas.
         */
        $response->assertStatus(201);

        /**
         * Nous vérifions enfin que les informations retournées qui ont été
         * enregistrées dans la base de données sont bien les mêmes que celles
         * qui avaient été générées aléatoirement au début de ce test.
         */
        $response->assertJson([
            'message' => 'Room created successfully',
            'room' => [
                'name' => $room->name,
                'is_booked' => $room->is_booked,
            ],
        ]);
    }

    /**
     * Jusqu'ici, nous avons vu les scenarii dits du "happy path",
     * c'est à dire lorsque tout est sensé bien se passer.
     * En revanche, il est important de ne pas tester que ces cas de figure,
     * mais d'être le plus exhaustif possible afin de garantir la
     * robustesse de son code. Il nous faut donc également tester ce
     * qu'il se passe lorsque l'on cherche un id qui n'existe pas par exemple.
     */
    public function test_show_returns_404_when_room_does_not_exist(): void
    {
        // Nous générons ici un id dont nous sommes certains qu'il n'existe pas dans la base de données.
        $nonExistentRoomId = Room::max('id') + 1;

        // Nous appelons notre route show
        $response = $this->getJson("/api/room/{$nonExistentRoomId}");

        /**
         * Puisque l'ID n'existe pas, nous notre application devrait
         * nous retourner un code 404 (qui signifie "not found")
         */
        $response->assertStatus(404);
    }

    /**
     * Toujours dans l'idée de tester les scenarii "unhappy",
     * nous vérifions que, dans le cas où nous appelerions la route POST
     * sans donner aucun paramètre par exemple, notre application
     * "sait" comment le gérer et nous n'avons pas d'erreur inatendue.
     * C'est un bon moyen pour vous de vous assurer également que vous
     * avez créé un système robuste. Car si vous avez des erreurs qui
     * "cassent" votre système dès que l'on ne passe pas exactement
     * les paramètres attendus par exemple, vous avez créé une application
     * trop fragile et vous devriez y remédier.
     */
    public function test_store_returns_validation_errors_for_missing_fields(): void
    {
        // Nous essayons de créer une room sans fournir de données
        $response = $this->postJson('/api/room', []);

        // Nous nous assurons que le code retourné est 422 (Unprocessable Entity)
        $response->assertStatus(422);

        /**
         * Cette assertion nous permet de vérifier que notre validateur fonctionne
         * correctement et qu'il nous retourne le nom du ou des paramètres
         * required qui n'ont pas été fournis.
         * 
         * Pour rappel, nous avons défini les règles de validation dans la
         * méthode rules de notre StoreRoomRequest qui est utilisée par la
         * route store dans le RoomController.
         */
        $response->assertJsonValidationErrors(['name']);

        /**
         * Nous pourrions imaginer bien d'autres tests encore.
         * Par exemple, si is_booked n'est pas un booléen ou que
         * name a plus de 7 caractères, puisque ce sont les règles
         * que nous avions définies.
         * Vous devriez avoir ici suffisamment d'exemples pour
         * pouvoir faire vos propres tests dans vos contextes respectifs.
         */
    }
}
