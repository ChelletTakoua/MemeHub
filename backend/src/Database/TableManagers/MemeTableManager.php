<?php

namespace Database\TableManagers;

use Database\DatabaseQuery;
use Models\Meme;

class MemeTableManager extends TableManager
{

    //--------get methods----------------
    // general get method
    /**
     * Get memes from database based on parameters given in $params preformatted as an associative array
     * @param array $params
     * @return Meme[]
     */
    static public function getMeme(array $params = []): array
    {
        // Execute a SELECT query on the "memes" table, excluding memes that are in the "blocked_memes" table
        $queryObjects =  DatabaseQuery::executeQuery("select", "memes", [], $params, " id NOT IN (SELECT meme_id FROM blocked_memes)");
        // Initialize an empty array to hold the memes
        $memes = [];
        // Loop through each object returned by the query
        foreach ($queryObjects as $queryObject) {
            // Create a new Meme object using the data from the query object
            // and add it to the memes array
            $memes[] = new Meme(
                $queryObject['id'],
                $queryObject['template_id'],
                $queryObject['custom_title'],
                $queryObject['user_id'],
                $queryObject['creation_date'],
                $queryObject['result_img']
            );
        }
        // Return the array of Meme objects
        return $memes;
    }

    /**
     * Retrieves all memes from the database.
     *
     *
     * @param array $params An associative array of parameters to be used in the SQL query. Default is an empty array.
     * @return array An array of Meme objects.
     */
    static public function getAllMemes(array $params = []): array
    {
        // Execute a SELECT query on the "memes" table
        $queryObjects =  DatabaseQuery::executeQuery("select", "memes", [], $params);
        // Initialize an empty array to hold the memes
        $memes = [];
        // Loop through each object returned by the query
        foreach ($queryObjects as $queryObject) {
            // Create a new Meme object using the data from the query object
            // and add it to the memes array
            $memes[] = new Meme(
                $queryObject['id'],
                $queryObject['template_id'],
                $queryObject['custom_title'],
                $queryObject['user_id'],
                $queryObject['creation_date'],
                $queryObject['result_img']
            );
        }
        // Return the array of Meme objects
        return $memes;
    }

    // specific get methods
    /**
     * Retrieves a meme from the database by its ID.
     *
     *
     * @param int $id The ID of the meme to retrieve.
     * @param bool $blocked Whether to include blocked memes. Default is false.
     * @return Meme|null The Meme object if found, null otherwise.
     */
    static public function getMemeById(int $id, bool $blocked = false): ?Meme
    {
        // If the ID is less than 0, return null
        if ($id < 0) {
            return null;
        }
        // If $blocked is true, retrieve all memes (including blocked ones) with the given ID
        // Otherwise, retrieve only non-blocked memes with the given ID
        if ($blocked) {
            $memes = self::getAllMemes(["id" => $id]);
        } else {
            $memes = self::getMeme(["id" => $id]);
        }
        // If the $memes array is not empty, return the first meme
        // Otherwise, return null
        if (!empty($memes)) {
            return $memes[0];
        }
        return null;
    }

    /**
     * Retrieves memes from the database by their template ID.
     *
     *
     * @param int $template_id The ID of the template to retrieve memes for.
     * @return array|null An array of Meme objects if found, null otherwise.
     */
    static public function getMemeByTemplateId(int $template_id): ?array
    {
        // Check if the template exists in the database using the templateExists method of the TemplateTableManager class
        // If the template does not exist, return null
        if (!TemplateTableManager::templateExists($template_id)) {
            return null;
        }
        // If the template exists, retrieve all memes that use this template by calling the getMeme method with the template ID
        return self::getMeme(["template_id" => $template_id]);
    }

    /**
     * Retrieves memes from the database by their user ID.
     *
     *
     * @param int $user_id The ID of the user to retrieve memes for.
     * @return array|null An array of Meme objects if found, null otherwise.
     */
    static public function getMemeByUserId(int $user_id): ?array
    {
        // Check if the user exists in the database using the verifyExistenceById method of the UserTableManager class
        // If the user does not exist, return null
        if (!UserTableManager::verifyExistenceById($user_id)) {
            return null;
        }
        // If the user exists, retrieve all memes created by this user by calling the getMeme method with the user ID
        return self::getMeme(["user_id" => $user_id]);
    }

    /**
     * Retrieves memes from the database by their creation date.
     *
     *
     * @param string $creation_date The creation date to retrieve memes for, in the format "YYYY-MM-DD HH:MM:SS".
     * @return array|null An array of Meme objects if found, null otherwise.
     */
    static public function getMemeByCreationDate(string $creation_date): ?array
    {
        // Check if the creation date string is empty or does not match the required format
        // The required format is "YYYY-MM-DD HH:MM:SS"
        // If the date string is empty or does not match the format, return null
        if (empty($creation_date) || !preg_match("/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/", $creation_date)) {
            return null;
        }
        // If the date string is valid, retrieve all memes created on this date by calling the getMeme method with the creation date
        return self::getMeme(["creation_date" => $creation_date]);
    }

    /**
     * Retrieves memes from the database by their custom title.
     *
     *
     * @param string $custom_title The custom title to retrieve memes for.
     * @return array|null An array of Meme objects if found, null otherwise.
     */
    static public function getMemeByCustomTitle(string $custom_title): ?array
    {
        // Check if the custom title string is empty
        // If the title string is empty, return null
        if (empty($custom_title)) {
            return null;
        }
        // If the title string is not empty, retrieve all memes with this custom title by calling the getMeme method with the custom title
        return self::getMeme(["custom_title" => $custom_title]);
    }

    /**
     * Retrieves memes from the database by their number of likes.
     *
     *
     * @param int $nb_likes The number of likes to retrieve memes for.
     * @return array|null An array of Meme objects if found, null otherwise.
     */
    static public function getMemeByNbLikes(int $nb_likes): ?array
    {
        // Check if the number of likes is less than 0
        // If the number of likes is less than 0, return null
        if ($nb_likes < 0) {
            return null;
        }
        // If the number of likes is not less than 0, retrieve all memes with this number of likes by calling the getMeme method with the number of likes
        return self::getMeme(["nb_likes" => $nb_likes]);
    }

    //--------verify existence methods----------------
    /**
     * Checks if a meme exists in the database by its ID.
     *
     *
     * @param int $id The ID of the meme to check.
     * @return bool True if the meme exists, false otherwise.
     */
    static public function memeExists(int $id): bool
    {
        // Call the getMemeById method with the given ID
        // If the returned meme is not empty, return true
        // Otherwise, return false
        return !empty(self::getMemeById($id));
    }

    /**
     * Checks if a meme exists in the database by its template ID.
     *
     *
     * @param int $template_id The ID of the template to check.
     * @return bool True if the meme exists, false otherwise.
     */
    static public function memeExistsByTemplateId(int $template_id): bool
    {
        // Call the getMemeByTemplateId method with the given template ID
        // If the returned meme is not empty, return true
        // Otherwise, return false
        return !empty(self::getMemeByTemplateId($template_id));
    }

    /**
     * Checks if a meme exists in the database by its user ID.
     *
     *
     * @param int $user_id The ID of the user to check.
     * @return bool True if the meme exists, false otherwise.
     */
    static public function memeExistsByUserId(int $user_id): bool
    {
        // Call the getMemeByUserId method with the given user ID
        // If the returned meme is not empty, return true
        // Otherwise, return false
        return !empty(self::getMemeByUserId($user_id));
    }

    /**
     * Checks if a meme exists in the database by its custom title.
     *
     *
     * @param string $custom_title The custom title to check.
     * @return bool True if the meme exists, false otherwise.
     */
    static public function memeExistsByCustomTitle(string $custom_title): bool
    {
        // Call the getMemeByCustomTitle method with the given custom title
        // If the returned meme is not empty, return true
        // Otherwise, return false
        return !empty(self::getMemeByCustomTitle($custom_title));
    }


    //--------add method----------------
    /**
     * Add meme to database based on template_id, custom_title and user_id given as parameters and return the meme object
     * @param int $template_id
     * @param string $custom_title
     * @param int $user_id
     * @param string $result_img
     * @return Meme|null
     */
    static public function addMeme(int $template_id, string $custom_title, int $user_id, string $result_img): ?Meme
    {
        // Check if the user and the template exist in the database
        // If they do not exist, return null
        if (!UserTableManager::verifyExistenceById($user_id) || !TemplateTableManager::templateExists($template_id)) {
            return null;
        }
        // If the user and the template exist, insert a new meme into the database with the given details
        DatabaseQuery::executeQuery("insert", "memes", ["template_id" => $template_id, "custom_title" => $custom_title, "user_id" => $user_id, "result_img" => $result_img]);
        // Get the ID of the newly inserted meme
        $id = DatabaseQuery::getLastInsertId();
        // Return the newly created meme
        return self::getMemeById($id);
    }

    //--------update methods----------------
    // general update method
    /**
     * Update meme in database based on id and attributes given as parameters and return the meme object
     * @param int $id
     * @param array $attributes
     * @return Meme|null
     */
    static public function updateMeme(int $id, array $attributes): ?Meme
    {
        // Check if the meme exists in the database
        // If it does not exist, return null
        if (!self::memeExists($id)) {
            return null;
        }
        // If the meme exists, update it in the database with the given attributes
        DatabaseQuery::executeQuery("update", "memes", $attributes, ["id" => $id]);
        // Return the updated meme
        return self::getMemeById($id);
    }

    // specific update methods
    /**
     * Updates the template ID of a meme in the database.
     *
     *
     * @param int $id The ID of the meme to update.
     * @param int $template_id The new template ID for the meme.
     * @return Meme|null The updated Meme object if successful, null otherwise.
     */
    static public function updateMemeTemplateId(int $id, int $template_id): ?Meme
    {
        // Check if the template and the meme exist in the database
        // If they do not exist, return null
        if (!TemplateTableManager::templateExists($template_id) || !self::memeExists($id)) {
            return null;
        }
        // If they exist, update the meme in the database with the new template ID
        return self::updateMeme($id, ["template_id" => $template_id]);
    }

    /**
     * Updates the custom title of a meme in the database.
     *
     *
     * @param int $id The ID of the meme to update.
     * @param string $custom_title The new custom title for the meme.
     * @return Meme|null The updated Meme object if successful, null otherwise.
     */
    static public function updateMemeCustomTitle(int $id, string $custom_title): ?Meme
    {
        // Check if the custom title is not empty and the meme exists in the database
        // If not, return null
        if (empty($custom_title) || !self::memeExists($id)) {
            return null;
        }
        // If they do, update the meme in the database with the new custom title
        return self::updateMeme($id, ["custom_title" => $custom_title]);
    }

    /**
     * Updates the user ID of a meme in the database.
     *
     * @param int $id The ID of the meme to update.
     * @param int $user_id The new user ID for the meme.
     * @return Meme|null The updated Meme object if successful, null otherwise.
     */
    static public function updateMemeUserId(int $id, int $user_id): ?Meme
    {
        // Check if the user and the meme exist in the database
        // If they do not exist, return null
        if (!UserTableManager::verifyExistenceById($user_id) || !self::memeExists($id)) {
            return null;
        }
        // If they exist, update the meme in the database with the new user ID
        return self::updateMeme($id, ["user_id" => $user_id]);
    }

    /**
     * Updates the result image of a meme in the database.
     *
     *
     * @param int $id The ID of the meme to update.
     * @param string $result_img The new result image for the meme.
     * @return Meme|null The updated Meme object if successful, null otherwise.
     */
    static public function updateMemeResultImg(int $id, string $result_img): ?Meme
    {
        // Check if the result image is not empty and the meme exists in the database
        // If not, return null
        if (empty($result_img) || !self::memeExists($id)) {
            return null;
        }
        // If they do, update the meme in the database with the new result image
        return self::updateMeme($id, ["result_img" => $result_img]);
    }

    //--------delete method----------------
    /**
     * Delete meme from database based on id given as parameter
     * @param int $id
     */
    static public function deleteMeme(int $id): void
    {
        // Check if the meme exists in the database
        // If it does not exist, return without doing anything
        if (!self::memeExists($id)) {
            return;
        }
        // If the meme exists, delete it from the database
        DatabaseQuery::executeQuery("delete", "memes", [], ["id" => $id]);
    }

    //--------save and retrieve methods----------------
    public function save($model)
    {
        echo "MemeTableManager save method called";
    }

    /**
     * Retrieves a Meme model from the database.
     *
     *
     * @param int $id The ID of the meme to retrieve.
     * @return Meme|null The Meme model if found, null otherwise.
     */
    public static function retrieve($id): ?Meme
    {
        // Retrieve the Meme model from the database using the given ID
        return self::getMemeById($id, true);
    }

    //--------sort methods----------------

    /**
     * Sort an array of memes by their creation date in ascending order
     * @param array $memes
     * @return array
     */
    static public function sortMemesByDate(array $memes): array
    {
        usort($memes, function ($a, $b) {
            return strtotime($a->getCreationDate()) <=> strtotime($b->getCreationDate());
        });
        return $memes;
    }
}
