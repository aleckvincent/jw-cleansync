<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Assignment;
use App\Entity\Team;
use App\Entity\Volunteer;
use Doctrine\ORM\EntityManagerInterface;

class AssignmentTest extends ApiTestCase
{
  public function testCreateAssignment(): void
  {
    $client = self::createClient();
    $entityManager = static::getContainer()->get(EntityManagerInterface::class);

    $team = $this->createTeam($entityManager);
    $volunteer = $this->createVolunteer($entityManager);

    $entityManager->flush();

     $client->request('POST', '/api/assignments', [
      'json' => [
        'activity' => 'Vacuum',
        'day' => 'Sat',
        'team' => '/api/teams/' . $team->getId(),
        'volunteer' => '/api/volunteers/' . $volunteer->getId(),
      ],
    ]);

    $this->assertResponseStatusCodeSame(201);
    $this->assertJsonContains([
      'activity' => 'Vacuum',
      'day' => 'Sat',
      'team' => '/api/teams/' . $team->getId(),
      'volunteer' => '/api/volunteers/' . $volunteer->getId(),
    ]);
  }

  public function testGetAssignments(): void
  {
    $client = self::createClient();
    $client->request('GET', '/api/assignments');

    $this->assertResponseIsSuccessful();
    $this->assertMatchesResourceCollectionJsonSchema(Assignment::class);
  }

  public function testUpdateAssignment(): void
  {

    $entityManager = static::getContainer()->get(EntityManagerInterface::class);

    $team = $this->createTeam($entityManager);
    $volunteer = $this->createVolunteer($entityManager);

    $assignment = new Assignment();
    $assignment
      ->setTeam($team)
      ->setVolunteer($volunteer)
      ->setDay('Fri')
      ->setActivity('Hover');

    $client = static::createClient();
    $iri = '/api/assignments/4';

    $data = [
      'activity' => 'Mopping',
      'day' => 'Sun',
    ];

    $client->request('PATCH', $iri, [
      'json' => $data,
      'headers' => [
        'Content-Type' => 'application/merge-patch+json',
      ],
    ]);

    $this->assertResponseIsSuccessful();
    $this->assertJsonContains([
      '@id' => $iri,
      'activity' => 'Mopping',
      'day' => 'Sun',
    ]);
  }

  private function createTeam(EntityManagerInterface $entityManager): Team
  {
    $team = new Team();
    $team->setArea('A');
    $entityManager->persist($team);
    return $team;
  }

  private function createVolunteer(EntityManagerInterface $entityManager): Volunteer
  {
    $volunteer = new Volunteer();
    $volunteer->setFirstName('Carole');
    $volunteer->setLastName('Daudu');
    $entityManager->persist($volunteer);
    return $volunteer;
  }

}
